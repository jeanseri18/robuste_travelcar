<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::with(['reservation', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reservations = Reservation::where('statut', 'en_attente')
                                 ->whereDoesntHave('paiement', function ($query) {
                                     $query->where('statut', 'complete');
                                 })
                                 ->with('user')
                                 ->get();
        
        return view('paiements.create', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant' => 'required|numeric|min:0',
            'methode' => 'required|in:orange_money,mtn_money,moov_money,wave,cheque,virement',
            'numero_transaction' => 'nullable|string|max:255',
            'reference_transaction' => 'nullable|string|max:255',
            'statut' => 'required|in:en_attente,complete,echoue,remboursement',
            'commentaire' => 'nullable|string',
        ]);

        // Récupérer la réservation et l'utilisateur
        $reservation = Reservation::findOrFail($request->reservation_id);

        // Créer le paiement
        $paiement = Paiement::create(array_merge(
            $request->all(),
            [
                'user_id' => $reservation->user_id,
                'date_paiement' => Carbon::now(),
            ]
        ));

        // Si le paiement est complet, mettre à jour le statut de la réservation
        if ($request->statut === 'complete') {
            $reservation->update(['statut' => 'confirmee']);
        }

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        $paiement->load(['reservation', 'user', 'reservation.societe']);
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paiement $paiement)
    {
        $paiement->load('reservation');
        return view('paiements.edit', compact('paiement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'methode' => 'required|in:orange_money,mtn_money,moov_money,wave,cheque,virement',
            'numero_transaction' => 'nullable|string|max:255',
            'reference_transaction' => 'nullable|string|max:255',
            'statut' => 'required|in:en_attente,complete,echoue,remboursement',
            'commentaire' => 'nullable|string',
        ]);

        $oldStatut = $paiement->statut;
        $paiement->update($request->all());

        // Si le statut a changé pour 'complete', mettre à jour la réservation
        if ($oldStatut !== 'complete' && $request->statut === 'complete') {
            $paiement->reservation->update(['statut' => 'confirmee']);
        }
        // Si le statut a changé de 'complete' à autre chose, mettre à jour la réservation
        elseif ($oldStatut === 'complete' && $request->statut !== 'complete') {
            $paiement->reservation->update(['statut' => 'en_attente']);
        }

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        // Si le paiement était complet, mettre à jour la réservation
        if ($paiement->statut === 'complete') {
            $paiement->reservation->update(['statut' => 'en_attente']);
        }

        $paiement->delete();

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }
}