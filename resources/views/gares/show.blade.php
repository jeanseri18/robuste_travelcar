@extends('layouts.app')

@section('title', 'Détails Gare | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de la Gare</h1>
        <div>
            <a href="{{ route('gares.edit', $gare->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('gares.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Générales</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>{{ $gare->nom_gare }}</h5>
                        <p class="text-muted">
                            Société: <a href="{{ route('societes.show', $gare->societe->id) }}">{{ $gare->societe->nom_commercial }}</a>
                        </p>
                        
                        @if($gare->est_actif)
                            <span class="badge bg-success">Gare active</span>
                        @else
                            <span class="badge bg-danger">Gare inactive</span>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Localisation</h6>
                        <p>
                            <i class="bi bi-geo-alt me-2"></i> <strong>Ville:</strong> {{ $gare->ville }}
                        </p>
                        @if($gare->commune)
                        <p>
                            <i class="bi bi-building me-2"></i> <strong>Commune:</strong> {{ $gare->commune }}
                        </p>
                        @endif
                        @if($gare->adresse)
                        <p>
                            <i class="bi bi-pin-map me-2"></i> <strong>Adresse:</strong> {{ $gare->adresse }}
                        </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Contact</h6>
                        @if($gare->responsable)
                        <p>
                            <i class="bi bi-person me-2"></i> <strong>Responsable:</strong> {{ $gare->responsable }}
                        </p>
                        @endif
                        @if($gare->telephone)
                        <p>
                            <i class="bi bi-telephone me-2"></i> <strong>Téléphone:</strong> 
                            <a href="tel:{{ $gare->telephone }}">{{ $gare->telephone }}</a>
                        </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div>
                        <p>
                            <i class="bi bi-clock-history me-2"></i> <strong>Créée le:</strong> {{ $gare->created_at->format('d/m/Y') }}
                        </p>
                        <p>
                            <i class="bi bi-clock me-2"></i> <strong>Dernière mise à jour:</strong> {{ $gare->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Destinations Nationales -->
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Destinations Nationales</h6>
                    <a href="{{ route('destinations_national.create', ['gare' => $gare->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter
                    </a>
                </div>
                <div class="card-body">
                    @if($gare->destinationsNational->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="destinationsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Départ</th>
                                    <th>Arrivée</th>
                                    <th>Tarif</th>
                                    <th>Horaires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gare->destinationsNational as $destination)
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
                                    <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                    <td>{{ substr($destination->premier_depart, 0, 5) }} - {{ substr($destination->dernier_depart, 0, 5) }}</td>
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
                        <p class="mt-3">Aucune destination nationale configurée pour cette gare.</p>
                        <a href="{{ route('destinations_national.create', ['gare' => $gare->id]) }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Ajouter une destination
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Destinations Sous-régionales -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Destinations Sous-régionales</h6>
                    <a href="{{ route('destinations_sousregion.create', ['gare' => $gare->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter
                    </a>
                </div>
                <div class="card-body">
                    @if($gare->destinationsSousRegion->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="destinationsSRTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Pays</th>
                                    <th>Ville</th>
                                    <th>Tarif</th>
                                    <th>Horaires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gare->destinationsSousRegion as $destination)
                                <tr>
                                    <td>{{ $destination->pays_destination }}</td>
                                    <td>{{ $destination->ville_destination }}</td>
                                    <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                    <td>{{ substr($destination->premier_depart, 0, 5) }} - {{ substr($destination->dernier_depart, 0, 5) }}</td>
                                    <td>
                                        <a href="{{ route('destinations_sousregion.show', $destination->id) }}" class="btn btn-info btn-sm">
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
                        <i class="bi bi-globe" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-3">Aucune destination sous-régionale configurée pour cette gare.</p>
                        <a href="{{ route('destinations_sousregion.create', ['gare' => $gare->id]) }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Ajouter une destination
                        </a>
                    </div>
                    @endif
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
        $('#destinationsTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]]
        });
        
        $('#destinationsSRTable').DataTable({
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