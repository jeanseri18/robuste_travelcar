@extends('layouts.app')

@section('title', 'Gestion des Paiements | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-credit-card-fill text-primary me-2"></i>
                Gestion des Paiements
            </h1>
            <p class="text-muted mb-0">Suivez et gérez tous les paiements des réservations</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter un Paiement
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
                                Total Paiements
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paiements->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-receipt text-primary" style="font-size: 2rem;"></i>
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
                                Paiements Validés
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paiements->where('statut', 'valide')->count() }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paiements->where('statut', 'en_attente')->count() }}</div>
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
                                Montant Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} CFA</div>
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
            <form id="filterForm" method="GET" action="{{ route('paiements.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="complete" {{ request('statut') == 'complete' ? 'selected' : '' }}>Complété</option>
                            <option value="echoue" {{ request('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                            <option value="remboursement" {{ request('statut') == 'remboursement' ? 'selected' : '' }}>Remboursement</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="methode" class="form-label">Méthode</label>
                        <select class="form-select" id="methode" name="methode">
                            <option value="">Toutes les méthodes</option>
                            <option value="orange_money" {{ request('methode') == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                            <option value="mtn_money" {{ request('methode') == 'mtn_money' ? 'selected' : '' }}>MTN Money</option>
                            <option value="moov_money" {{ request('methode') == 'moov_money' ? 'selected' : '' }}>Moov Money</option>
                            <option value="wave" {{ request('methode') == 'wave' ? 'selected' : '' }}>Wave</option>
                            <option value="cheque" {{ request('methode') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                            <option value="virement" {{ request('methode') == 'virement' ? 'selected' : '' }}>Virement</option>
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
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <!-- Total des paiements -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total des paiements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalPaiements ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-wallet2 fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements complétés -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Paiements complétés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalCompletes ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements en attente -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Paiements en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalEnAttente ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements échoués -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Paiements échoués</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalEchoues ?? 0, 0, ',', ' ') }} CFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paiements Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Paiements
                </h6>
                <span class="badge bg-light text-primary fs-6">{{ $paiements->count() }} paiements</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold"><i class="bi bi-hash me-1"></i>ID</th>
                            <th class="fw-bold"><i class="bi bi-ticket me-1"></i>Réservation</th>
                            <th class="fw-bold"><i class="bi bi-person me-1"></i>Client</th>
                            <th class="fw-bold"><i class="bi bi-currency-exchange me-1"></i>Montant</th>
                            <th class="fw-bold"><i class="bi bi-credit-card me-1"></i>Méthode</th>
                            <th class="fw-bold"><i class="bi bi-calendar me-1"></i>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiements as $paiement)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $paiement->id }}</span></td>
                                <td>
                                    <a href="{{ route('reservations.show', $paiement->reservation->id) }}" class="text-decoration-none">
                                        <span class="badge bg-info text-white">
                                            <i class="bi bi-ticket me-1"></i>
                                            {{ $paiement->reservation->code_reservation }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $paiement->user->id) }}" class="text-decoration-none">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-primary me-2"></i>
                                            <strong>{{ $paiement->user->nom }} {{ $paiement->user->prenom }}</strong>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        <i class="bi bi-currency-exchange me-1"></i>
                                        {{ number_format($paiement->montant, 0, ',', ' ') }} CFA
                                    </span>
                                </td>
                                <td>
                                    @switch($paiement->methode)
                                        @case('orange_money')
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-phone me-1"></i>
                                                Orange Money
                                            </span>
                                            @break
                                        @case('mtn_money')
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="bi bi-phone me-1"></i>
                                                MTN Money
                                            </span>
                                            @break
                                        @case('moov_money')
                                            <span class="badge bg-info rounded-pill">
                                                <i class="bi bi-phone me-1"></i>
                                                Moov Money
                                            </span>
                                            @break
                                        @case('wave')
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-phone me-1"></i>
                                                Wave
                                            </span>
                                            @break
                                        @case('cheque')
                                            <span class="badge bg-secondary rounded-pill">
                                                <i class="bi bi-check2-square me-1"></i>
                                                Chèque
                                            </span>
                                            @break
                                        @case('virement')
                                            <span class="badge bg-dark rounded-pill">
                                                <i class="bi bi-bank me-1"></i>
                                                Virement
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary rounded-pill">{{ $paiement->methode }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : $paiement->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @switch($paiement->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-clock me-1"></i>
                                                En attente
                                            </span>
                                            @break
                                        @case('complete')
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Complété
                                            </span>
                                            @break
                                        @case('echoue')
                                            <span class="badge bg-danger rounded-pill">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Échoué
                                            </span>
                                            @break
                                        @case('remboursement')
                                            <span class="badge bg-info rounded-pill">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                                Remboursement
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary rounded-pill">{{ $paiement->statut }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paiements.show', $paiement->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('paiements.edit', $paiement->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $paiement->id }}"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $paiement->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $paiement->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce paiement de <strong>{{ number_format($paiement->montant, 0, ',', ' ') }} CFA</strong> ?
                                                    <br>
                                                    Cette action est irréversible et pourrait affecter le statut de la réservation associée.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .card:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
    .badge {
        font-size: 0.75rem;
    }
    .bg-light-primary {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }
    .bg-light-success {
        background-color: rgba(28, 200, 138, 0.1) !important;
    }
    .bg-light-info {
        background-color: rgba(54, 185, 204, 0.1) !important;
    }
    .bg-light-warning {
        background-color: rgba(246, 194, 62, 0.1) !important;
    }
    .bg-light-danger {
        background-color: rgba(231, 74, 59, 0.1) !important;
    }
</style>
@endpush
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