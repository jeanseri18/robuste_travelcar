<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\DestinationNational;
use App\Models\DestinationSousRegion;
use App\Models\Paiement;
use App\Models\Societe;
use App\Models\Gare;
use App\Models\Lieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the traveler's reservations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = $request->user()->reservations()
            ->with(['societe', 'destination', 'gare', 'paiement'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservations,
        ]);
    }

    /**
     * Store a newly created reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_destination' => 'required|in:national,sousregion',
            'destination_id' => 'required|integer',
            'societe_id' => 'required|exists:societes,id',
            'gare_depart' => 'required|exists:gares,id',
            'lieu_embarquement' => 'required|string',
            'date_depart' => 'required|date',
            'heure_depart' => 'required',
            'tarif_unitaire' => 'required|numeric',
            'nombre_tickets' => 'required|integer|min:1',
            'assurance_voyageur' => 'required|boolean',
            'assurance_bagages' => 'required|boolean',
            'nom_voyageur' => 'nullable|string',
            'contact_voyageur' => 'nullable|string',
            'commentaire' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate destination exists
        if ($request->type_destination === 'national') {
            $destination = DestinationNational::find($request->destination_id);
        } else {
            $destination = DestinationSousRegion::find($request->destination_id);
        }

        if (!$destination) {
            return response()->json([
                'status' => 'error',
                'message' => 'Destination not found',
            ], 404);
        }

        // Calculate total and insurance cost
        $total = $request->tarif_unitaire * $request->nombre_tickets;
        $cout_assurance = 0;
        
        // Example insurance calculation
        if ($request->assurance_voyageur) {
            $cout_assurance += 1000; // 1000 CFA per ticket for traveler insurance
        }
        
        if ($request->assurance_bagages) {
            $cout_assurance += 500; // 500 CFA per ticket for baggage insurance
        }
        
        $total += $cout_assurance;

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => $request->user()->id,
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
            'assurance_voyageur' => $request->assurance_voyageur,
            'assurance_bagages' => $request->assurance_bagages,
            'cout_assurance' => $cout_assurance,
            'statut' => 'en_attente',
            'statut_paiement' => 'espece',
            'nom_voyageur' => $request->nom_voyageur,
            'contact_voyageur' => $request->contact_voyageur,
            'commentaire' => $request->commentaire,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Réservation créée avec succès',
            'data' => $reservation->load(['societe', 'destination', 'gare']),
        ], 201);
    }

    /**
     * Display the specified reservation.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $reservation = $request->user()->reservations()
            ->with(['societe', 'destination', 'gare', 'paiement'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $reservation,
        ]);
    }

    /**
     * Update the specified reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = $request->user()->reservations()->findOrFail($id);
        
        // Check if reservation can be updated (only if it's pending)
        if ($reservation->statut !== 'en_attente') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cette réservation ne peut plus être modifiée',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'lieu_embarquement' => 'nullable|string',
            'nom_voyageur' => 'nullable|string',
            'contact_voyageur' => 'nullable|string',
            'commentaire' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $reservation->update($request->only([
            'lieu_embarquement', 'nom_voyageur', 'contact_voyageur', 'commentaire'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Réservation mise à jour avec succès',
            'data' => $reservation->load(['societe', 'destination', 'gare']),
        ]);
    }

    /**
     * Cancel the specified reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $id)
    {
        $reservation = $request->user()->reservations()->findOrFail($id);
        
        // Check if reservation can be cancelled (only if it's pending)
        if ($reservation->statut !== 'en_attente') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cette réservation ne peut plus être annulée',
            ], 403);
        }

        $reservation->update([
            'statut' => 'annulee'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Réservation annulée avec succès',
            'data' => $reservation,
        ]);
    }
}