<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\Societe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Affiche la page du tableau de bord.
     */
    public function index()
    {
        // Statistiques des réservations
        $totalReservations = Reservation::count();
        $monthlyReservations = Reservation::whereMonth('created_at', Carbon::now()->month)
                                         ->whereYear('created_at', Carbon::now()->year)
                                         ->count();
        $yearlyReservations = Reservation::whereYear('created_at', Carbon::now()->year)
                                        ->count();

        // Statistiques des paiements
        $totalPaid = Paiement::where('statut', 'complete')->sum('montant');
        $monthlyPaid = Paiement::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->where('statut', 'complete')
                              ->sum('montant');
        $yearlyPaid = Paiement::whereYear('created_at', Carbon::now()->year)
                             ->where('statut', 'complete')
                             ->sum('montant');

        // Données pour le graphique des réservations mensuelles
        $monthlyLabels = [];
        $monthlyData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->locale('fr_FR')->monthName;
            $monthlyLabels[] = ucfirst($monthName);
            
            $count = Reservation::whereMonth('created_at', $i)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->count();
            
            $monthlyData[] = $count;
        }

        // Statistiques supplémentaires
        $societeCount = Societe::count();
        $userCount = User::count();
        $reservationsPending = Reservation::where('statut', 'en_attente')->count();
        $reservationsConfirmed = Reservation::where('statut', 'confirmee')->count();

        // Top 5 des destinations les plus réservées
        $topDestinations = Reservation::select('destination_id', 'type_destination', DB::raw('count(*) as total'))
                          ->groupBy('destination_id', 'type_destination')
                          ->orderByDesc('total')
                          ->limit(5)
                          ->get();

        return view('dashboard.index', compact(
            'totalReservations',
            'monthlyReservations',
            'yearlyReservations',
            'totalPaid',
            'monthlyPaid',
            'yearlyPaid',
            'monthlyLabels',
            'monthlyData',
            'societeCount',
            'userCount',
            'reservationsPending',
            'reservationsConfirmed',
            'topDestinations'
        ));
    }
}