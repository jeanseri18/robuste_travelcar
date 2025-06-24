@extends('layouts.app')

@section('title', 'Destinations Sous-régionales | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-geo-alt text-primary me-2"></i>
                Gestion des Destinations Sous-régionales
            </h1>
            <p class="text-muted mb-0">Gérez les destinations de transport sous-régional</p>
        </div>
        <a href="{{ route('destinations_sousregion.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter une Destination
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-left-success shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Succès!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Destinations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-geo-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sociétés Actives
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->pluck('societe')->unique()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pays Desservis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->pluck('pays_destination')->unique()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-flag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tarif Moyen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($destinations->avg('tarif_unitaire'), 0, ',', ' ') }} CFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-exchange fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Destinations Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Destinations Sous-régionales
                </h6>
                <span class="badge bg-light text-primary">{{ $destinations->count() }} destinations</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th><strong><i class="bi bi-hash me-1"></i>ID</strong></th>
                            <th><strong><i class="bi bi-building me-1"></i>Société</strong></th>
                            <th><strong><i class="bi bi-geo-alt me-1"></i>Gare de Départ</strong></th>
                            <th><strong><i class="bi bi-arrow-right me-1"></i>Départ</strong></th>
                            <th><strong><i class="bi bi-flag me-1"></i>Destination</strong></th>
                            <th><strong><i class="bi bi-currency-exchange me-1"></i>Tarif</strong></th>
                            <th><strong><i class="bi bi-clock me-1"></i>Horaires</strong></th>
                            <th><strong><i class="bi bi-gear me-1"></i>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destinations as $destination)
                            <tr>
                                <td>
                                    <i class="bi bi-hash text-muted me-1"></i>
                                    <strong>{{ $destination->id }}</strong>
                                </td>
                                <td>
                                    @if($destination->societe)
                                        <span class="badge rounded-pill bg-success">
                                            <i class="bi bi-building me-1"></i>
                                            {{ $destination->societe->nom_commercial }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">
                                            <i class="bi bi-question-circle me-1"></i>
                                            Non spécifié
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($destination->gareDepart)
                                        <i class="bi bi-geo-alt text-primary me-1"></i>
                                        <strong>{{ $destination->gareDepart->nom_gare }}</strong>
                                    @else
                                        <i class="bi bi-x-circle text-muted me-1"></i>
                                        <span class="text-muted">Non spécifié</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-geo text-info me-1"></i>
                                    <small class="text-muted d-block">{{ $destination->pays_depart ?? 'Non spécifié' }}</small>
                                    <strong>{{ $destination->ville_depart ?? 'Non spécifié' }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-flag text-warning me-1"></i>
                                    <small class="text-muted d-block">{{ $destination->pays_destination }}</small>
                                    <strong>{{ $destination->ville_destination }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-currency-exchange text-success me-1"></i>
                                    <strong class="text-success">{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</strong>
                                </td>
                                <td>
                                    <i class="bi bi-clock text-info me-1"></i>
                                    <span class="badge bg-light text-dark">
                                        {{ substr($destination->premier_depart, 0, 5) }} - {{ substr($destination->dernier_depart, 0, 5) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('destinations_sousregion.show', $destination->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('destinations_sousregion.edit', $destination->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $destination->id }}"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $destination->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $destination->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $destination->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la destination 
                                                    <strong>
                                                        Côte d'Ivoire → {{ $destination->pays_destination }} ({{ $destination->ville_destination }})
                                                    </strong> ?
                                                    <br>
                                                    Cette action est irréversible.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('destinations_sousregion.destroy', $destination->id) }}" method="POST" class="d-inline">
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
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
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
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .btn {
        transition: all 0.2s ease;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
    .badge {
        font-size: 0.75em;
    }
    .bg-light-primary {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }
    .bg-light-success {
        background-color: rgba(28, 200, 138, 0.1) !important;
    }
    .bg-light-warning {
        background-color: rgba(246, 194, 62, 0.1) !important;
    }
    .bg-light-danger {
        background-color: rgba(231, 74, 59, 0.1) !important;
    }
    .bg-light-info {
        background-color: rgba(54, 185, 204, 0.1) !important;
    }
</style>
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