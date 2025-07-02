@extends('layouts.app')

@section('title', 'Gestion des Lieux | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-pin-map-fill text-primary me-2"></i>
                Gestion des Lieux
            </h1>
            <p class="text-muted mb-0">Gérez les villes et destinations disponibles</p>
        </div>
        <a href="{{ route('lieux.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter un Lieu
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
                                Total Lieux
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lieux->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-geo-alt text-primary" style="font-size: 2rem;"></i>
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
                                Lieux de Départ
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lieux->where('type', 'depart')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-up-circle text-success" style="font-size: 2rem;"></i>
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
                                Lieux d'Arrivée
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lieux->where('type', 'arrivee')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-down-circle text-info" style="font-size: 2rem;"></i>
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
                                Lieux Actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lieux->where('statut', 'actif')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lieux Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Lieux
                </h6>
                <span class="badge bg-light text-primary fs-6">{{ $lieux->count() }} lieux</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold"><i class="bi bi-hash me-1"></i>ID</th>
                            <th class="fw-bold"><i class="bi bi-building me-1"></i>Ville</th>
                            <th class="fw-bold"><i class="bi bi-geo me-1"></i>Commune</th>
                            <th class="fw-bold"><i class="bi bi-map me-1"></i>Région</th>
                            <th class="fw-bold"><i class="bi bi-tag me-1"></i>Type</th>
                            <th class="fw-bold"><i class="bi bi-toggle-on me-1"></i>Statut</th>
                            <th class="fw-bold"><i class="bi bi-gear me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lieux as $lieu)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $lieu->id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building text-primary me-2"></i>
                                        <strong>{{ $lieu->ville }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="bi bi-geo me-1"></i>
                                        {{ $lieu->commune ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-map me-1"></i>
                                        {{ $lieu->region ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td>
                                    @switch($lieu->type)
                                        @case('depart')
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="bi bi-arrow-up-circle me-1"></i>
                                                Départ
                                            </span>
                                            @break
                                        @case('arrive')
                                            <span class="badge bg-info rounded-pill">
                                                <i class="bi bi-arrow-down-circle me-1"></i>
                                                Arrivée
                                            </span>
                                            @break
                                        @case('les_deux')
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-arrow-left-right me-1"></i>
                                                Départ & Arrivée
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary rounded-pill">{{ $lieu->type }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($lieu->est_actif)
                                        <span class="badge bg-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Actif
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('lieux.show', $lieu->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('lieux.edit', $lieu->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill delete-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $lieu->id }}"
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

<!-- Delete Modals -->
@foreach($lieux as $lieu)
    <div class="modal fade" id="deleteModal{{ $lieu->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $lieu->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $lieu->id }}">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer le lieu <strong>{{ $lieu->ville }}</strong> ?
                    <br>
                    Cette action est irréversible et supprimera également toutes les destinations associées.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('lieux.destroy', $lieu->id) }}" method="POST" class="d-inline">
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