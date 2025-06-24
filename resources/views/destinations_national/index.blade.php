@extends('layouts.app')

@section('title', 'Destinations Nationales | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                Gestion des Destinations Nationales
            </h1>
            <p class="text-muted mb-0">Gérez les itinéraires et destinations nationales</p>
        </div>
        <a href="{{ route('destinations_national.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter une Destination
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
                                Total Destinations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-map text-primary" style="font-size: 2rem;"></i>
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
                                Sociétés Actives
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->pluck('societe_id')->unique()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building text-success" style="font-size: 2rem;"></i>
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
                                Gares de Départ
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $destinations->pluck('gare_depart_id')->unique()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-train-front text-info" style="font-size: 2rem;"></i>
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
                                Tarif Moyen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($destinations->avg('tarif'), 0) }} CFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-exchange text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Destinations Table -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-primary py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Destinations Nationales
                </h6>
                <span class="badge bg-light text-primary">{{ $destinations->count() }} destinations</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 fw-bold">#</th>
                            <th class="border-0 fw-bold"><i class="bi bi-building me-1"></i>Société</th>
                            <th class="border-0 fw-bold"><i class="bi bi-geo-alt me-1"></i>Gare de Départ</th>
                            <th class="border-0 fw-bold"><i class="bi bi-arrow-right me-1"></i>Itinéraire</th>
                            <th class="border-0 fw-bold"><i class="bi bi-currency-exchange me-1"></i>Tarif</th>
                            <th class="border-0 fw-bold"><i class="bi bi-clock me-1"></i>Horaires</th>
                            <th class="border-0 fw-bold text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($destinations as $destination)
                            <tr class="align-middle">
                                <td class="fw-bold text-primary">#{{ $destination->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="bi bi-building text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $destination->societe->nom_commercial ?? 'Non spécifié' }}</div>
                                            @if($destination->societe)
                                                <small class="text-muted">{{ $destination->societe->forme_juridique ?? '' }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info px-3 py-2">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td>
                                    @if($destination->lieuDepart && $destination->lieuArrive)
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success-subtle text-success me-2">{{ $destination->lieuDepart->ville }}</span>
                                            <i class="bi bi-arrow-right text-muted mx-1"></i>
                                            <span class="badge bg-warning-subtle text-warning">{{ $destination->lieuArrive->ville }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Itinéraire incomplet
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-success fs-6">
                                        {{ number_format($destination->tarif_unitaire, 0, ',', ' ') }}
                                        <small class="text-muted">CFA</small>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock text-primary me-2"></i>
                                        <span class="badge bg-light text-dark">
                                            {{ substr($destination->premier_depart, 0, 5) }} - {{ substr($destination->dernier_depart, 0, 5) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('destinations_national.show', $destination->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('destinations_national.edit', $destination->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $destination->id }}"
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
                                                        @if($destination->lieuDepart && $destination->lieuArrive)
                                                            {{ $destination->lieuDepart->ville }} → {{ $destination->lieuArrive->ville }}
                                                        @else
                                                            #{{ $destination->id }}
                                                        @endif
                                                    </strong> ?
                                                    <br>
                                                    Cette action est irréversible.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('destinations_national.destroy', $destination->id) }}" method="POST" class="d-inline">
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
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
    }
    .avatar-sm {
        width: 2.5rem;
        height: 2.5rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    .btn-group .btn {
        transition: all 0.2s ease;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.75rem;
    }
    .bg-info-subtle {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1) !important;
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