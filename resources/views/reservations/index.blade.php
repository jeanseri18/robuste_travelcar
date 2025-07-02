@extends('layouts.app')

@section('title', 'Gestion des Réservations | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-calendar-check-fill text-primary me-2"></i>
                Gestion des Réservations
            </h1>
            <p class="text-muted mb-0">Gérez toutes les réservations de voyages</p>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Nouvelle Réservation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Réservations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reservations->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Confirmées
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reservations->where('statut', 'confirmee')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                En Attente
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reservations->where('statut', 'en_attente')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Revenus Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($reservations->sum('montant_total'), 0, ',', ' ') }} CFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-exchange text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('reservations.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                            <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ request('date_fin') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="societe_id" class="form-label">Société</label>
                        <select class="form-select" id="societe_id" name="societe_id">
                            <option value="">Toutes les sociétés</option>
                            @foreach($societes ?? [] as $societe)
                                <option value="{{ $societe->id }}" {{ request('societe_id') == $societe->id ? 'selected' : '' }}>
                                    {{ $societe->nom_commercial }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Réservations Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Réservations
                </h6>
                <span class="badge bg-light text-primary">{{ $reservations->count() }} réservations</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th><strong><i class="bi bi-hash me-1"></i>Code</strong></th>
                            <th><strong><i class="bi bi-person me-1"></i>Client</strong></th>
                            <th><strong><i class="bi bi-geo-alt me-1"></i>Destination</strong></th>
                            <th><strong><i class="bi bi-calendar me-1"></i>Date</strong></th>
                            <th><strong><i class="bi bi-ticket me-1"></i>Tickets</strong></th>
                            <th><strong><i class="bi bi-currency-exchange me-1"></i>Total</strong></th>
                            <th><strong><i class="bi bi-check-circle me-1"></i>Statut</strong></th>
                            <th><strong><i class="bi bi-credit-card me-1"></i>Paiement</strong></th>
                            <th><strong><i class="bi bi-gear me-1"></i>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-hash me-1"></i>{{ $reservation->code_reservation }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $reservation->user->id) }}" class="text-decoration-none">
                                        <i class="bi bi-person-circle me-1 text-primary"></i>
                                        <strong>{{ $reservation->nom_client }}</strong>
                                    </a>
                                </td>
                                <td>
                                    @if($reservation->type_destination === 'national')
                                        @php
                                            $dest = App\Models\DestinationNational::with(['lieuDepart', 'lieuArrive'])->find($reservation->destination_id);
                                        @endphp
                                        @if($dest && $dest->lieuDepart && $dest->lieuArrive)
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $dest->lieuDepart->ville }}
                                            </span>
                                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $dest->lieuArrive->ville }}
                                            </span>
                                        @else
                                            <span class="badge bg-info rounded-pill">
                                                <i class="bi bi-map me-1"></i>Destination nationale
                                            </span>
                                        @endif
                                    @else
                                        @php
                                            $dest = App\Models\DestinationSousRegion::find($reservation->destination_id);
                                        @endphp
                                        @if($dest)
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="bi bi-geo-alt me-1"></i>CDI
                                            </span>
                                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-globe me-1"></i>{{ $dest->pays_destination }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">
                                                <i class="bi bi-globe me-1"></i>Destination sous-régionale
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-calendar-date me-1 text-muted"></i>
                                    <strong>{{ $reservation->date_depart->format('d/m/Y') }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info rounded-pill">
                                        <i class="bi bi-ticket-perforated me-1"></i>{{ $reservation->nombre_tickets }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        <i class="bi bi-currency-exchange me-1"></i>{{ number_format($reservation->total, 0, ',', ' ') }} CFA
                                    </strong>
                                </td>
                                <td>
                                    @switch($reservation->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-clock me-1"></i>En attente
                                            </span>
                                            @break
                                        @case('confirmee')
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>Confirmée
                                            </span>
                                            @break
                                        @case('annulee')
                                            <span class="badge bg-danger rounded-pill">
                                                <i class="bi bi-x-circle me-1"></i>Annulée
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary rounded-pill">
                                                <i class="bi bi-question-circle me-1"></i>{{ $reservation->statut }}
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($reservation->paiement)
                                        @switch($reservation->paiement->statut)
                                            @case('en_attente')
                                                <span class="badge bg-warning rounded-pill">
                                                    <i class="bi bi-clock me-1"></i>En attente
                                                </span>
                                                @break
                                            @case('complete')
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i>Complété
                                                </span>
                                                @break
                                            @case('echoue')
                                                <span class="badge bg-danger rounded-pill">
                                                    <i class="bi bi-x-circle me-1"></i>Échoué
                                                </span>
                                                @break
                                            @case('remboursement')
                                                <span class="badge bg-info rounded-pill">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Remboursé
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary rounded-pill">
                                                    <i class="bi bi-question-circle me-1"></i>{{ $reservation->paiement->statut }}
                                                </span>
                                        @endswitch
                                    @else
                                        <span class="badge bg-secondary rounded-pill">
                                            <i class="bi bi-credit-card me-1"></i>Non payé
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('reservations.show', $reservation->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill delete-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $reservation->id }}"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals de suppression -->
@foreach($reservations as $reservation)
    <div class="modal fade" id="deleteModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $reservation->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $reservation->id }}">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer la réservation <strong>{{ $reservation->code_reservation }}</strong> ?
                    <br>
                    Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.btn {
    transition: all 0.3s ease;
}

/* Animation normale pour tous les boutons sauf ceux qui déclenchent des modals */
.btn:hover {
    transform: translateY(-1px);
}

/* Désactiver l'animation pour les boutons de suppression (modals) */
.delete-btn:hover {
    transform: none !important;
}

/* Assurer la stabilité des modals */
.modal {
    position: fixed !important;
    z-index: 1055 !important;
}

.modal-dialog {
    transform: none !important;
}

.modal-content {
    transform: none !important;
}

.badge {
    font-size: 0.75rem;
}

.bg-light {
    background-color: #f8f9fc !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>
@push('styles')
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#Table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"

            }
        });
    });
</script>
@endpush