@extends('layouts.app')

@section('title', 'Tableau de Bord | TravelCar225')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de Bord</h1>
    </div>

    <!-- Statistiques des Réservations -->
    <div class="row">
        <!-- Réservations Totales -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white h-100" style="background-color:#FF513A">
                <div class="card-header">
                    <i class="bi bi-card-checklist"></i> Réservations Totales
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ $totalReservations }}</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Réservations du Mois -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-header">
                    <i class="bi bi-calendar-check"></i> Réservations du Mois
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ $monthlyReservations }}</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Réservations de l'Année -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white h-100" style="background-color:orange">
                <div class="card-header">
                    <i class="bi bi-calendar-year"></i> Réservations de l'Année
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ $yearlyReservations }}</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('reservations.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques des Paiements -->
    <div class="row">
        <!-- Total Payé -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white h-100" style="background-color:#FF513A">
                <div class="card-header">
                    <i class="bi bi-wallet2"></i> Total Payé
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ number_format($totalPaid, 0, ',', ' ') }} CFA</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('paiements.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Payé ce Mois -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-header">
                    <i class="bi bi-wallet"></i> Total Payé ce Mois
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ number_format($monthlyPaid, 0, ',', ' ') }} CFA</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('paiements.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Payé cette Année -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card text-white h-100" style="background-color:orange">
                <div class="card-header">
                    <i class="bi bi-wallet2"></i> Total Payé cette Année
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ number_format($yearlyPaid, 0, ',', ' ') }} CFA</h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('paiements.index') }}" class="text-white text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques supplémentaires -->
    <div class="row">
        <!-- Sociétés de transport -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sociétés de transport</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $societeCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('societes.index') }}" class="text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Réservations en attente -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Réservations en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reservationsPending ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reservations.index') }}?statut=en_attente" class="text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Réservations confirmées -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Réservations confirmées</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reservationsConfirmed ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reservations.index') }}?statut=confirmee" class="text-decoration-none">
                        Voir Détails <i class="bi bi-arrow-right"></i>
                    </a>
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