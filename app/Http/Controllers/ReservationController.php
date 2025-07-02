<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\DestinationNational;
use App\Models\DestinationSousRegion;
use App\Models\Societe;
use App\Models\Gare;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'societe', 'gare', 'paiement'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $societes = Societe::with([
            'gares' => function($query) {
                $query->with([
                    'destinationsNational' => function($subQuery) {
                        $subQuery->with(['lieuDepart', 'lieuArrive']);
                    },
                    'destinationsSousRegion'
                ]);
            }
        ])->get();
        
        // Ajouter les propriétés pour JavaScript tout en gardant les objets originaux
        $societes->each(function($societe) {
            $societe->gares->each(function($gare) {
                $gare->destinations_national = $gare->destinationsNational;
                $gare->destinations_sous_region = $gare->destinationsSousRegion;
            });
        });
        
        return view('reservations.create', compact('societes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'type_destination' => 'required|in:national,sousregion',
            'destination_id' => 'required|integer',
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'lieu_embarquement' => 'required|string',
            'date_depart' => 'required|date|after_or_equal:today',
            'heure_depart' => 'required|date_format:H:i',
            'tarif_unitaire' => 'required|numeric|min:0',
            'nombre_tickets' => 'required|integer|min:1',
            'assurance_voyageur' => 'boolean',
            'assurance_bagages' => 'boolean',
            'nom_voyageur' => 'nullable|string',
            'contact_voyageur' => 'nullable|string',
            'commentaire' => 'nullable|string',
        ]);

        // Calculer le total
        $total = $request->tarif_unitaire * $request->nombre_tickets;
        if ($request->assurance_voyageur || $request->assurance_bagages) {
            $total += $request->cout_assurance;
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'nom_client' => $request->nom_client,
            'type_destination' => $request->type_destination,
            'destination_id' => $request->destination_id,
            'societe_id' => $request->societe_id,
            'gare_depart' => $request->gare_depart,
            'lieu_embarquement' => $request->lieu_embarquement,
            'date_depart' => $request->date_depart,
            'heure_depart' => $request->heure_depart,
            'tarif_unitaire' => $request->tarif_unitaire,
            'nombre_tickets' => $request->nombre_tickets,
            'total' => $total,
            'assurance_voyageur' => $request->has('assurance_voyageur'),
            'assurance_bagages' => $request->has('assurance_bagages'),
            'nom_voyageur' => $request->nom_voyageur,
            'contact_voyageur' => $request->contact_voyageur,
            'commentaire' => $request->commentaire,
            'statut' => 'en_attente',
            'code_reservation' => 'TRAV-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'societe', 'gare', 'paiement']);
        
        // Récupérer les détails de la destination selon le type
        if ($reservation->type_destination === 'national') {
            $destination = DestinationNational::with(['lieuDepart', 'lieuArrive'])
                                             ->find($reservation->destination_id);
        } else {
            $destination = DestinationSousRegion::find($reservation->destination_id);
        }

        return view('reservations.show', compact('reservation', 'destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $societes = Societe::orderBy('nom_commercial')->get();
        $gares = Gare::where('societe_id', $reservation->societe_id)->get();
        $users = User::where('type', 'Voyageur')->orderBy('nom')->get();
        
        // Récupérer les destinations selon le type
        if ($reservation->type_destination === 'national') {
            $destinations = DestinationNational::where('societe_id', $reservation->societe_id)
                                             ->with(['lieuDepart', 'lieuArrive'])
                                             ->get();
        } else {
            $destinations = DestinationSousRegion::where('societe_id', $reservation->societe_id)
                                               ->get();
        }

        return view('reservations.edit', compact(
            'reservation',
            'societes',
            'gares',
            'users',
            'destinations'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type_destination' => 'required|in:national,sousregion',
            'destination_id' => 'required|integer',
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'lieu_embarquement' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'heure_depart' => 'required',
            'tarif_unitaire' => 'required|numeric|min:0',
            'nombre_tickets' => 'required|integer|min:1',
            'assurance_voyageur' => 'boolean',
            'assurance_bagages' => 'boolean',
            'cout_assurance' => 'nullable|numeric|min:0',
            'statut' => 'required|in:en_attente,confirmee,annulee',
            'nom_voyageur' => 'nullable|string|max:255',
            'contact_voyageur' => 'nullable|string|max:255',
        ]);

        // Calculer le total
        $total = $request->tarif_unitaire * $request->nombre_tickets;
        if ($request->assurance_voyageur || $request->assurance_bagages) {
            $total += $request->cout_assurance;
        }

        // Mettre à jour la réservation
        $reservation->update(array_merge(
            $request->all(),
            ['total' => $total]
        ));

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }
    
    /**
     * Confirmer une réservation.
     */
    public function confirmer(Reservation $reservation)
    {
        $reservation->update(['statut' => 'confirmee']);
        
        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Réservation confirmée avec succès.');
    }
    
    /**
     * Annuler une réservation.
     */
    public function annuler(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);
        
        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Réservation annulée avec succès.');
    }
}