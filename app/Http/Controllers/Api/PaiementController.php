<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Display a listing of the traveler's payments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paiements = Paiement::where('user_id', $request->user()->id)
            ->with(['reservation', 'reservation.societe'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $paiements,
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required|exists:reservations,id',
            'methode' => 'nullable|string',
            'numero_transaction' => 'nullable|string|max:255',
            'reference_transaction' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        // Check if reservation belongs to the user and is pending
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', $request->user()->id)
            ->where('statut', 'en_attente')
            ->firstOrFail();

        // Check if payment already exists
        $existingPayment = Paiement::where('reservation_id', $reservation->id)
            ->where('statut', 'complete')
            ->first();

        if ($existingPayment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Un paiement a déjà été effectué pour cette réservation',
            ], 400);
        }

         $reservation->update([
            'statut_paiement' => 'cinetpay'
         ]);
        // Create the payment (initially with 'en_attente' status)
        $paiement = Paiement::create([
            'reservation_id' => $reservation->id,
            'user_id' => $request->user()->id,
            'montant' => $reservation->total,
            'methode' => $request->methode,
            'numero_transaction' => $request->numero_transaction,
            'reference_transaction' => $request->reference_transaction,
            'statut' => 'en_attente', // Payment will be validated by an admin
            'date_paiement' => Carbon::now(),
            'commentaire' => $request->commentaire,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Paiement enregistré avec succès. Il sera validé par notre équipe prochainement.',
            'data' => $paiement->load('reservation'),
        ], 201);
    }

    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $paiement = Paiement::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['reservation', 'reservation.societe', 'reservation.destination'])
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => $paiement,
        ]);
    }

    public function getPaymentsByReservation(Request $request, $reservationId)
{
    // Vérifie si la réservation appartient bien à l'utilisateur connecté
    $reservation = Reservation::where('id', $reservationId)
        ->where('user_id', $request->user()->id)
        ->first();

    if (!$reservation) {
        return response()->json([
            'status' => 'error',
            'message' => 'Réservation introuvable ou non autorisée.',
        ], 404);
    }

    // Récupère les paiements liés à la réservation
    $paiements = Paiement::where('reservation_id', $reservationId)
        ->with(['reservation', 'reservation.societe'])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $paiements,
    ]);
}

}