@extends('layouts.app')

@section('title', 'Détails Lieu | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-geo-alt text-info me-2"></i>
                Détails du Lieu
            </h1>
            <p class="text-muted mb-0">Informations complètes sur {{ $lieu->ville }}</p>
        </div>
        <div>
            <a href="{{ route('lieux.edit', $lieu->id) }}" class="btn btn-outline-warning btn-lg shadow-sm me-2">
                <i class="bi bi-pencil me-2"></i> Modifier
            </a>
            <a href="{{ route('lieux.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations Générales -->
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h6 class="m-0 font-weight-bold d-flex align-items-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Informations Générales
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>{{ $lieu->ville }}</h5>
                        @if($lieu->commune)
                            <p class="text-muted">Commune: {{ $lieu->commune }}</p>
                        @endif
                        
                        <div class="mt-2">
                            @switch($lieu->type)
                                @case('depart')
                                    <span class="badge bg-primary">Lieu de départ</span>
                                    @break
                                @case('arrive')
                                    <span class="badge bg-info">Lieu d'arrivée</span>
                                    @break
                                @case('les_deux')
                                    <span class="badge bg-success">Lieu de départ & d'arrivée</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $lieu->type }}</span>
                            @endswitch
                            
                            @if($lieu->est_actif)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Localisation Administrative</h6>
                        @if($lieu->region)
                        <p>
                            <i class="bi bi-geo me-2"></i> <strong>Région:</strong> {{ $lieu->region }}
                        </p>
                        @endif
                        @if($lieu->departement)
                        <p>
                            <i class="bi bi-geo-alt me-2"></i> <strong>Département:</strong> {{ $lieu->departement }}
                        </p>
                        @endif
                        @if($lieu->sous_prefecture)
                        <p>
                            <i class="bi bi-pin-map me-2"></i> <strong>Sous-préfecture:</strong> {{ $lieu->sous_prefecture }}
                        </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div>
                        <p>
                            <i class="bi bi-clock-history me-2"></i> <strong>Créé le:</strong> {{ $lieu->created_at->format('d/m/Y') }}
                        </p>
                        <p>
                            <i class="bi bi-clock me-2"></i> <strong>Dernière mise à jour:</strong> {{ $lieu->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Destinations associées -->
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Destinations Nationales</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="destinationsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="depart-tab" data-bs-toggle="tab" data-bs-target="#depart-tab-pane" type="button" role="tab" aria-controls="depart-tab-pane" aria-selected="true">
                                Départs
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="arrive-tab" data-bs-toggle="tab" data-bs-target="#arrive-tab-pane" type="button" role="tab" aria-controls="arrive-tab-pane" aria-selected="false">
                                Arrivées
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-4" id="destinationsTabContent">
                        <!-- Destinations comme lieu de départ -->
                        <div class="tab-pane fade show active" id="depart-tab-pane" role="tabpanel" aria-labelledby="depart-tab" tabindex="0">
                            @if($lieu->departsNational->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="departsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Arrivée</th>
                                            <th>Société</th>
                                            <th>Gare</th>
                                            <th>Tarif</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lieu->departsNational as $destination)
                                        <tr>
                                            <td>
                                                @if($destination->lieuArrive)
                                                    {{ $destination->lieuArrive->ville }}
                                                    @if($destination->lieuArrive->commune)
                                                        - {{ $destination->lieuArrive->commune }}
                                                    @endif
                                                @else
                                                    Non spécifié
                                                @endif
                                            </td>
                                            <td>{{ $destination->societe->nom_commercial ?? 'Non spécifié' }}</td>
                                            <td>{{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}</td>
                                            <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                            <td>
                                                <a href="{{ route('destinations_national.show', $destination->id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-map" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-3">Aucune destination de départ configurée pour ce lieu.</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Destinations comme lieu d'arrivée -->
                        <div class="tab-pane fade" id="arrive-tab-pane" role="tabpanel" aria-labelledby="arrive-tab" tabindex="0">
                            @if($lieu->arrivesNational->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="arrivesTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Départ</th>
                                            <th>Société</th>
                                            <th>Gare</th>
                                            <th>Tarif</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lieu->arrivesNational as $destination)
                                        <tr>
                                            <td>
                                                @if($destination->lieuDepart)
                                                    {{ $destination->lieuDepart->ville }}
                                                    @if($destination->lieuDepart->commune)
                                                        - {{ $destination->lieuDepart->commune }}
                                                    @endif
                                                @else
                                                    Non spécifié
                                                @endif
                                            </td>
                                            <td>{{ $destination->societe->nom_commercial ?? 'Non spécifié' }}</td>
                                            <td>{{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}</td>
                                            <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                            <td>
                                                <a href="{{ route('destinations_national.show', $destination->id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-map" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="mt-3">Aucune destination d'arrivée configurée pour ce lieu.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/datatables.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#departsTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]]
        });
        
        $('#arrivesTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]]
        });
    });
</script>
@endpush