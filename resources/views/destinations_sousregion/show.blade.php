@extends('layouts.app')

@section('title', 'Détails Destination Sous-régionale | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de la Destination Sous-régionale</h1>
        <div>
            <a href="{{ route('destinations_sousregion.edit', $destination->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('destinations_sousregion.index') }}" class="btn btn-secondary">
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
        <!-- Informations générales -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la Destination</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>{{ $destination->pays_depart ?? 'Côte d\'Ivoire' }} → {{ $destination->pays_destination }}</h5>
                        <p class="text-muted">
                            <strong>Départ:</strong> {{ $destination->ville_depart ?? 'Non spécifié' }} <br>
                            <strong>Destination:</strong> {{ $destination->ville_destination }}
                        </p>
                        
                        @if($destination->est_actif)
                            <span class="badge bg-success">Destination active</span>
                        @else
                            <span class="badge bg-danger">Destination inactive</span>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Détails du trajet</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Pays de départ:</strong><br>
                                <span class="text-muted">{{ $destination->pays_depart ?? 'Non spécifié' }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Ville de départ:</strong><br>
                                <span class="text-muted">{{ $destination->ville_depart ?? 'Non spécifié' }}</span>
                            </div>
                        </div>
                        <hr>
                        <p>
                            <strong>Société:</strong> 
                            <a href="{{ route('societes.show', $destination->societe->id) }}">
                                {{ $destination->societe->nom_commercial }}
                            </a>
                        </p>
                        <p>
                            <strong>Gare de départ:</strong> 
                            <a href="{{ route('gares.show', $destination->gareDepart->id) }}">
                                {{ $destination->gareDepart->nom_gare }}
                            </a>
                        </p>
                        <p>
                            <strong>Pays de destination:</strong> {{ $destination->pays_destination }}
                        </p>
                        <p>
                            <strong>Ville de destination:</strong> {{ $destination->ville_destination }}
                        </p>
                        @if($destination->adresse_destination)
                            <p>
                                <strong>Adresse de destination:</strong> {{ $destination->adresse_destination }}
                            </p>
                        @endif
                        @if($destination->duree_trajet)
                            <p>
                                <strong>Durée du trajet:</strong> 
                                @if($destination->duree_trajet < 24)
                                    {{ $destination->duree_trajet }} heures
                                @else
                                    @php
                                        $jours = floor($destination->duree_trajet / 24);
                                        $heures = $destination->duree_trajet % 24;
                                    @endphp
                                    {{ $jours }} jour{{ $jours > 1 ? 's' : '' }}
                                    @if($heures > 0)
                                        et {{ $heures }} heure{{ $heures > 1 ? 's' : '' }}
                                    @endif
                                @endif
                            </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Tarification et horaires</h6>
                        <p>
                            <strong>Tarif unitaire:</strong> {{ number_format($destination->tarif_unitaire, 0, ',', ' ') }} CFA
                        </p>
                        <p>
                            <strong>Premier départ:</strong> {{ substr($destination->premier_depart, 0, 5) }}
                        </p>
                        <p>
                            <strong>Dernier départ:</strong> {{ substr($destination->dernier_depart, 0, 5) }}
                        </p>
                        @if($destination->capacite_bus)
                            <p>
                                <strong>Capacité par bus:</strong> {{ $destination->capacite_bus }} passagers
                            </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div>
                        <p>
                            <strong>Créée le:</strong> {{ $destination->created_at->format('d/m/Y') }}
                        </p>
                        <p>
                            <strong>Dernière mise à jour:</strong> {{ $destination->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Réservations -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Réservations</h6>
                </div>
                <div class="card-body">
                    @if($destination->reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="reservationsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($destination->reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->code_reservation }}</td>
                                            <td>{{ $reservation->date_depart->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $reservation->user->id) }}">
                                                    {{ $reservation->user->nom }} {{ $reservation->user->prenom }}
                                                </a>
                                            </td>
                                            <td>
                                                @switch($reservation->statut)
                                                    @case('en_attente')
                                                        <span class="badge bg-warning">En attente</span>
                                                        @break
                                                    @case('confirmee')
                                                        <span class="badge bg-success">Confirmée</span>
                                                        @break
                                                    @case('annulee')
                                                        <span class="badge bg-danger">Annulée</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $reservation->statut }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info btn-sm">
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
                            <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-3">Aucune réservation pour cette destination.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('reservations.create', ['destination' => $destination->id, 'type' => 'sousregion']) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Créer une réservation
                        </a>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Supprimer cette destination
                        </button>
                    </div>
                </div>
            </div>
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
                    Êtes-vous sûr de vouloir supprimer la destination 
                    <strong>
                        Côte d'Ivoire → {{ $destination->pays_destination }} ({{ $destination->ville_destination }})
                    </strong> ?
                    <br>
                    Cette action est irréversible et pourrait affecter les réservations existantes.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('destinations_sousregion.destroy', $destination->id) }}" method="POST" class="d-inline">
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
        $('#reservationsTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            },
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Tous"]],
            order: [[1, 'desc']]
        });
    });
</script>
@endpush