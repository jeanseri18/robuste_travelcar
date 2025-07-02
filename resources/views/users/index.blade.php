@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-people text-primary me-2"></i>
                Gestion des Utilisateurs
            </h1>
            <p class="text-muted mb-0">Gérez les comptes utilisateurs et leurs permissions</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Ajouter un Utilisateur
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
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
                                Total Utilisateurs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Administrateurs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('type', 'Administrateur')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-shield-check fa-2x text-danger"></i>
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
                                Voyageurs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('type', 'Voyageur')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fa-2x text-success"></i>
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
                                Sous-Traitants
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('type', 'Sous-Traitant')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-briefcase fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4 card-hover">
        <div class="card-header bg-primary py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="bi bi-table me-2"></i>
                    Liste des Utilisateurs
                </h6>
                <span class="badge bg-light text-primary fs-6">{{ $users->count() }} utilisateurs</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="Table" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th><strong><i class="bi bi-hash me-1"></i>ID</strong></th>
                            <th><strong><i class="bi bi-person-badge me-1"></i>Type</strong></th>
                            <th><strong><i class="bi bi-person me-1"></i>Nom</strong></th>
                            <th><strong><i class="bi bi-envelope me-1"></i>Email</strong></th>
                            <th><strong><i class="bi bi-telephone me-1"></i>Téléphone</strong></th>
                            <th><strong><i class="bi bi-shield me-1"></i>Rôle</strong></th>
                            <th><strong><i class="bi bi-calendar me-1"></i>Inscrit le</strong></th>
                            <th><strong><i class="bi bi-gear me-1"></i>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-hash me-1"></i>{{ $user->id }}
                                    </span>
                                </td>
                                <td>
                                    @switch($user->type)
                                        @case('Administrateur')
                                            <span class="badge bg-danger rounded-pill">
                                                <i class="bi bi-shield-check me-1"></i>{{ $user->type }}
                                            </span>
                                            @break
                                        @case('Voyageur')
                                            <span class="badge bg-success rounded-pill">
                                                <i class="bi bi-person-check me-1"></i>{{ $user->type }}
                                            </span>
                                            @break
                                        @case('Sous-Traitant')
                                            <span class="badge bg-warning rounded-pill">
                                                <i class="bi bi-briefcase me-1"></i>{{ $user->type }}
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary rounded-pill">
                                                <i class="bi bi-person me-1"></i>{{ $user->type }}
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <strong class="text-primary">
                                        <i class="bi bi-person me-2"></i>{{ $user->nom }} {{ $user->prenom }}
                                    </strong>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope text-info me-2"></i>
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($user->contact_telephone)
                                        <a href="tel:{{ $user->contact_telephone }}" class="text-decoration-none">
                                            <i class="bi bi-telephone text-success me-2"></i>
                                            <strong>{{ $user->contact_telephone }}</strong>
                                        </a>
                                    @else
                                        <i class="bi bi-telephone-x text-muted me-2"></i>
                                        <span class="text-muted">Non spécifié</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role)
                                        <span class="badge bg-info rounded-pill">
                                            <i class="bi bi-shield me-1"></i>{{ $user->role }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">
                                            <i class="bi bi-question-circle me-1"></i>Non défini
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-calendar text-primary me-2"></i>
                                    <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user->id) }}" 
                                           class="btn btn-outline-info btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                           class="btn btn-outline-warning btn-sm rounded-pill me-1" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill delete-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $user->id }}"
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
@foreach($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->nom }} {{ $user->prenom }}</strong> ?
                    <br>
                    Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
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