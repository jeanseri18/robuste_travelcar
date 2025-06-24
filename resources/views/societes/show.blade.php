@extends('layouts.app')

@section('title', 'Détails Société | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-building text-primary me-2"></i>
                Détails de la Société
            </h1>
            <p class="text-muted mb-0">Informations complètes sur {{ $societe->nom_commercial }}</p>
        </div>
        <div>
            <a href="{{ route('societes.edit', $societe->id) }}" class="btn btn-outline-warning btn-lg shadow-sm me-2">
                <i class="bi bi-pencil me-2"></i> Modifier
            </a>
            <a href="{{ route('societes.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
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
        <!-- Informations générales -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold d-flex align-items-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Informations de la Société
                    </h6>
                </div>
                <div class="card-body text-center mb-3">
                    @if($societe->logo)
                        <img src="{{ asset('storage/' . $societe->logo) }}" alt="{{ $societe->nom_commercial }}" class="img-fluid mb-3" style="max-height: 150px;">
                    @else
                        <i class="bi bi-building" style="font-size: 5rem; color: #1088F2;"></i>
                    @endif
                    
                    <h4>{{ $societe->nom_commercial }}</h4>
                    <p class="text-muted">
                        {{ $societe->forme_juridique ?? 'Forme juridique non spécifiée' }}
                    </p>
                    
                    <hr>
                    
                    <div class="text-start">
                        <p>
                            <i class="bi bi-geo-alt me-2"></i> <strong>Siège social:</strong> {{ $societe->siege_social ?? 'Non spécifié' }}
                        </p>
                        
                        @if($societe->date_creation)
                            <p>
                                <i class="bi bi-calendar me-2"></i> <strong>Date de création:</strong> {{ $societe->date_creation->format('d/m/Y') }}
                            </p>
                        @endif
                        
                        @if($societe->capital)
                            <p>
                                <i class="bi bi-cash-stack me-2"></i> <strong>Capital:</strong> {{ number_format($societe->capital, 0, ',', ' ') }} CFA
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Coordonnées -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Coordonnées</h6>
                </div>
                <div class="card-body">
                    @if($societe->adresse)
                        <p>
                            <i class="bi bi-geo me-2"></i> <strong>Adresse:</strong> {{ $societe->adresse }}
                        </p>
                    @endif
                    
                    @if($societe->email)
                        <p>
                            <i class="bi bi-envelope me-2"></i> <strong>Email:</strong> 
                            <a href="mailto:{{ $societe->email }}">{{ $societe->email }}</a>
                        </p>
                    @endif
                    
                    @if($societe->telephone)
                        <p>
                            <i class="bi bi-telephone me-2"></i> <strong>Téléphone:</strong> 
                            <a href="tel:{{ $societe->telephone }}">{{ $societe->telephone }}</a>
                        </p>
                    @endif
                    
                    @if($societe->whatsapp)
                        <p>
                            <i class="bi bi-whatsapp me-2"></i> <strong>WhatsApp:</strong> {{ $societe->whatsapp }}
                        </p>
                    @endif
                    
                    @if($societe->responsable_marketing)
                        <p>
                            <i class="bi bi-person me-2"></i> <strong>Responsable marketing:</strong> {{ $societe->responsable_marketing }}
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- Informations administratives -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations administratives</h6>
                </div>
                <div class="card-body">
                    @if($societe->rccm)
                        <p>
                            <strong>N° RCCM:</strong> {{ $societe->rccm }}
                        </p>
                    @endif
                    
                    @if($societe->compte_contribuable)
                        <p>
                            <strong>Compte contribuable:</strong> {{ $societe->compte_contribuable }}
                        </p>
                    @endif
                    
                    @if($societe->regime_imposition)
                        <p>
                            <strong>Régime d'imposition:</strong> {{ $societe->regime_imposition }}
                        </p>
                    @endif
                    
                    @if($societe->centre_impots)
                        <p>
                            <strong>Centre des impôts:</strong> {{ $societe->centre_impots }}
                        </p>
                    @endif
                    
                    @if($societe->compte_bancaire)
                        <p>
                            <strong>Compte bancaire:</strong> {{ $societe->compte_bancaire }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Gares et Destinations -->
        <div class="col-lg-8">
            <!-- Gares -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Gares</h6>
                    <a href="{{ route('gares.create', ['societe' => $societe->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter une gare
                    </a>
                </div>
                <div class="card-body">
                    @if($societe->gares->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="garesTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Localisation</th>
                                        <th>Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($societe->gares as $gare)
                                        <tr>
                                            <td>{{ $gare->nom_gare }}</td>
                                            <td>{{ $gare->ville }}{{ $gare->commune ? ' - ' . $gare->commune : '' }}</td>
                                            <td>{{ $gare->telephone ?? 'Non spécifié' }}</td>
                                            <td>
                                                <a href="{{ route('gares.show', $gare->id) }}" class="btn btn-info btn-sm">
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
                            <i class="bi bi-shop" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-3">Aucune gare enregistrée pour cette société.</p>
                            <a href="{{ route('gares.create', ['societe' => $societe->id]) }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Ajouter une gare
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Destinations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Destinations</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="destinationsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="national-tab" data-bs-toggle="tab" data-bs-target="#national-tab-pane" type="button" role="tab" aria-controls="national-tab-pane" aria-selected="true">
                                Nationales
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sousregion-tab" data-bs-toggle="tab" data-bs-target="#sousregion-tab-pane" type="button" role="tab" aria-controls="sousregion-tab-pane" aria-selected="false">
                                Sous-régionales
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-4" id="destinationsTabContent">
                        <!-- Destinations nationales -->
                        <div class="tab-pane fade show active" id="national-tab-pane" role="tabpanel" aria-labelledby="national-tab" tabindex="0">
                            @if($societe->destinationsNational->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="destinationsNationalTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Gare</th>
                                                <th>Itinéraire</th>
                                                <th>Tarif</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($societe->destinationsNational as $destination)
                                                <tr>
                                                    <td>{{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}</td>
                                                    <td>
                                                        @if($destination->lieuDepart && $destination->lieuArrive)
                                                            {{ $destination->lieuDepart->ville }} → {{ $destination->lieuArrive->ville }}
                                                        @else
                                                            Itinéraire incomplet
                                                        @endif
                                                    </td>
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
                                    <p class="mt-3">Aucune destination nationale enregistrée pour cette société.</p>
                                    <a href="{{ route('destinations_national.create', ['societe' => $societe->id]) }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle"></i> Ajouter une destination nationale
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Destinations sous-régionales -->
                        <div class="tab-pane fade" id="sousregion-tab-pane" role="tabpanel" aria-labelledby="sousregion-tab" tabindex="0">
                            @if($societe->destinationsSousRegion->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="destinationsSousRegionTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Gare</th>
                                                <th>Destination</th>
                                                <th>Tarif</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($societe->destinationsSousRegion as $destination)
                                                <tr>
                                                    <td>{{ $destination->gareDepart->nom_gare ?? 'Non spécifié' }}</td>
                                                    <td>{{ $destination->pays_destination }} - {{ $destination->ville_destination }}</td>
                                                    <td>{{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA</td>
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
                                    <p class="mt-3">Aucune destination sous-régionale enregistrée pour cette société.</p>
                                    <a href="{{ route('destinations_sousregion.create', ['societe' => $societe->id]) }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle"></i> Ajouter une destination sous-régionale
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bouton Supprimer -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Zone dangereuse</h6>
        </div>
        <div class="card-body">
            <p>
                <strong>Attention:</strong> La suppression d'une société entraînera également la suppression de toutes ses gares, destinations et réservations associées. Cette action est irréversible.
            </p>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash"></i> Supprimer cette société
            </button>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
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
                        <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                    </form>
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
        $('#garesTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]]
        });
        
        $('#destinationsNationalTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]]
        });
        
        $('#destinationsSousRegionTable').DataTable({
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