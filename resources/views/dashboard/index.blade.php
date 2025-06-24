@extends('layouts.app')

@section('title', 'Tableau de Bord | TravelCar225')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de Bord</h1>
    </div>

    <!-- Statistiques des Réservations -->
    <h2 class="section-title">Statistiques des Réservations</h2>
    <div class="row">
        <!-- Réservations Totales -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-coral">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <div class="stats-number">{{ $totalReservations }}</div>
                    <div class="stats-label">Réservations Totales</div>
                    <div class="mt-3">
                        <a href="{{ route('reservations.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations du Mois -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-emerald">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="stats-number">{{ $monthlyReservations }}</div>
                    <div class="stats-label">Réservations du Mois</div>
                    <div class="mt-3">
                        <a href="{{ route('reservations.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations de l'Année -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-purple">
                        <i class="bi bi-calendar-year"></i>
                    </div>
                    <div class="stats-number">{{ $yearlyReservations }}</div>
                    <div class="stats-label">Réservations de l'Année</div>
                    <div class="mt-3">
                        <a href="{{ route('reservations.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques des Paiements -->
    <h2 class="section-title">Statistiques des Paiements</h2>
    <div class="row">
        <!-- Total Payé -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-ocean">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stats-number">{{ number_format($totalPaid, 0, ',', ' ') }}</div>
                    <div class="stats-label">Total Payé (CFA)</div>
                    <div class="mt-3">
                        <a href="{{ route('paiements.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Payé ce Mois -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-amber">
                        <i class="bi bi-wallet"></i>
                    </div>
                    <div class="stats-number">{{ number_format($monthlyPaid, 0, ',', ' ') }}</div>
                    <div class="stats-label">Payé ce Mois (CFA)</div>
                    <div class="mt-3">
                        <a href="{{ route('paiements.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Payé cette Année -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-teal">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="stats-number">{{ number_format($yearlyPaid, 0, ',', ' ') }}</div>
                    <div class="stats-label">Payé cette Année (CFA)</div>
                    <div class="mt-3">
                        <a href="{{ route('paiements.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Autres Statistiques -->
    <h2 class="section-title">Autres Statistiques</h2>
    <div class="row">
        <!-- Entreprises de Transport -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-indigo">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="stats-number">{{ $societeCount ?? 0 }}</div>
                    <div class="stats-label">Entreprises de Transport</div>
                    <div class="mt-3">
                        <a href="{{ route('societes.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-pink">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stats-number">{{ $userCount ?? 0 }}</div>
                    <div class="stats-label">Utilisateurs</div>
                    <div class="mt-3">
                        <a href="{{ route('users.index') }}" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations en Attente -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-amber">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="stats-number">{{ $reservationsPending ?? 0 }}</div>
                    <div class="stats-label">Réservations en Attente</div>
                    <div class="mt-3">
                        <a href="{{ route('reservations.index') }}?statut=en_attente" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations Confirmées -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body text-center">
                    <div class="stats-icon mx-auto icon-emerald">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stats-number">{{ $reservationsConfirmed ?? 0 }}</div>
                    <div class="stats-label">Réservations Confirmées</div>
                    <div class="mt-3">
                        <a href="{{ route('reservations.index') }}?statut=confirmee" class="stats-link">
                            Voir Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des Réservations Mensuelles -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Graphique des Réservations Mensuelles</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="reservationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Destinations -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Destinations</h6>
                </div>
                <div class="card-body">
                    @if(isset($topDestinations) && count($topDestinations) > 0)
                        <ul class="list-group">
                            @foreach($topDestinations as $destination)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if($destination->type_destination === 'national')
                                        @php
                                            $dest = App\Models\DestinationNational::with(['lieuDepart', 'lieuArrive'])->find($destination->destination_id);
                                        @endphp
                                        @if($dest && $dest->lieuDepart && $dest->lieuArrive)
                                            {{ $dest->lieuDepart->ville }} - {{ $dest->lieuArrive->ville }}
                                        @else
                                            Destination inconnue
                                        @endif
                                    @else
                                        @php
                                            $dest = App\Models\DestinationSousRegion::find($destination->destination_id);
                                        @endphp
                                        @if($dest)
                                            Côte d'Ivoire - {{ $dest->pays_destination }} ({{ $dest->ville_destination }})
                                        @else
                                            Destination inconnue
                                        @endif
                                    @endif
                                    <span class="badge bg-primary rounded-pill">{{ $destination->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">Aucune destination réservée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-container {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .dashboard-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 30px;
        position: relative;
    }
    
    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #3498db;
        border-radius: 2px;
    }
    
    .stats-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        border-color: #dee2e6;
    }
    
    .stats-card .card-body {
        padding: 25px;
        position: relative;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
        color: white;
    }
    
    .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 10px 0;
        color: #2c3e50;
    }
    
    .stats-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stats-link {
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }
    
    .stats-link:hover {
        color: #212529;
    }
    
    /* Couleurs spécifiques pour chaque icône */
    .icon-coral {
        background-color: #dc3545;
    }
    
    .icon-emerald {
        background-color: #28a745;
    }
    
    .icon-purple {
        background-color: #6f42c1;
    }
    
    .icon-ocean {
        background-color: #007bff;
    }
    
    .icon-amber {
        background-color: #fd7e14;
    }
    
    .icon-teal {
        background-color: #14b8a6;
    }
    
    .icon-indigo {
        background-color: #6366f1;
    }
    
    .icon-rose {
        background-color: #f43f5e;
    }
    
    .icon-orange {
        background-color: #f97316;
    }
    
    .icon-green {
        background-color: #22c55e;
    }
    
    .icon-pink {
        background-color: #ec4899;
    }
    
    .icon-indigo {
        background-color: #6610f2;
    }
    
    .icon-pink {
        background-color: #e83e8c;
    }
    
    .icon-cyan {
        background-color: #17a2b8;
    }
    
    .icon-success {
        background-color: #198754;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin: 40px 0 20px 0;
        font-size: 1.3rem;
        border-left: 4px solid #3498db;
        padding-left: 15px;
    }
    
    .chart-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .chart-card .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('reservationsChart').getContext('2d');
        var reservationsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Réservations',
                    data: @json($monthlyData),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' réservations';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script>
@endpush