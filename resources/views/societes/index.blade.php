@extends('layouts.app')

@section('title', 'Gestion des Sociétés | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-building text-primary me-2"></i>
                Gestion des Sociétés de Transport
            </h1>
            <p class="text-muted mb-0">Gérez toutes les sociétés de transport partenaires</p>
        </div>
        <!-- <a href="{{ route('societes.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter une Société
        </a> -->
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
                                Total Sociétés
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $societes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
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
                                Actives
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $societes->where('statut', 'actif')->count() }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $societes->where('statut', 'en_attente')->count() }}</div>
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
                                Total Gares
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $societes->sum(function($s) { return $s->gares->count(); }) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-geo-alt text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sociétés Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Sociétés
                </h6>
                <span class="badge bg-light text-primary">{{ $societes->count() }} sociétés</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th><strong><i class="bi bi-hash me-1"></i>ID</strong></th>
                            <th><strong><i class="bi bi-image me-1"></i>Logo</strong></th>
                            <th><strong><i class="bi bi-building me-1"></i>Nom Commercial</strong></th>
                            <th><strong><i class="bi bi-briefcase me-1"></i>Forme Juridique</strong></th>
                            <th><strong><i class="bi bi-telephone me-1"></i>Contact</strong></th>
                            <th><strong><i class="bi bi-geo-alt me-1"></i>Gares</strong></th>
                            <th><strong><i class="bi bi-gear me-1"></i>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($societes as $societe)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-hash me-1"></i>{{ $societe->id }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($societe->logo)
                                        <img src="{{ asset('storage/' . $societe->logo) }}" alt="{{ $societe->nom_commercial }}" width="50" class="rounded-circle shadow-sm">
                                    @else
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-building text-primary" style="font-size: 1.5rem;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-primary">
                                        <i class="bi bi-building me-1"></i>{{ $societe->nom_commercial }}
                                    </strong>
                                </td>
                                <td>
                                    @if($societe->forme_juridique)
                                        <span class="badge bg-info rounded-pill">
                                            <i class="bi bi-briefcase me-1"></i>{{ $societe->forme_juridique }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">
                                            <i class="bi bi-question-circle me-1"></i>Non spécifié
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($societe->telephone)
                                        <a href="tel:{{ $societe->telephone }}" class="text-decoration-none">
                                            <i class="bi bi-telephone-fill me-1 text-success"></i>
                                            <strong>{{ $societe->telephone }}</strong>
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="bi bi-telephone-x me-1"></i>Non spécifié
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $societe->gares->count() }} gare(s)
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('societes.show', $societe->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('societes.edit', $societe->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $societe->id }}"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $societe->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $societe->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $societe->id }}">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
<div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer la société <strong>{{ $societe->nom_commercial }}</strong> ?
                                                    <br>
                                                    Cette action est irréversible et supprimera également toutes les gares, destinations et réservations associées.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('societes.destroy', $societe->id) }}" method="POST" class="d-inline">
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

.btn:hover {
    transform: translateY(-1px);
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

.rounded-circle {
    border: 2px solid #e3e6f0;
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