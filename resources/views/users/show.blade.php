@extends('layouts.app')

@section('title', 'Détails Utilisateur | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de l'Utilisateur</h1>
        <div>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
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
        <!-- User Profile Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="avatar mb-3">
                            <i class="bi bi-person-circle" style="font-size: 8rem; color: #1088F2;"></i>
                        </div>
                        <h5 class="mb-2">{{ $user->nom }} {{ $user->prenom }}</h5>
                        
                        @switch($user->type)
                            @case('Administrateur')
                                <span class="badge bg-danger mb-2">{{ $user->type }}</span>
                                @break
                            @case('Voyageur')
                                <span class="badge bg-success mb-2">{{ $user->type }}</span>
                                @break
                            @case('Sous-Traitant')
                                <span class="badge bg-warning mb-2">{{ $user->type }}</span>
                                @break
                            @default
                                <span class="badge bg-secondary mb-2">{{ $user->type }}</span>
                        @endswitch
                        
                        <p class="text-muted">{{ $user->role }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <div class="mb-2">
                            <strong><i class="bi bi-envelope me-2"></i> Email:</strong>
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <strong><i class="bi bi-telephone me-2"></i> Téléphone:</strong>
                            <a href="tel:{{ $user->contact_telephone }}">{{ $user->contact_telephone }}</a>
                        </div>
                        
                        @if($user->whatsapp)
                        <div class="mb-2">
                            <strong><i class="bi bi-whatsapp me-2"></i> WhatsApp:</strong>
                            {{ $user->whatsapp }}
                        </div>
                        @endif
                        
                        @if($user->date_naissance)
                        <div class="mb-2">
                            <strong><i class="bi bi-calendar me-2"></i> Date de naissance:</strong>
                            {{ $user->date_naissance->format('d/m/Y') }}
                        </div>
                        @endif
                        
                        @if($user->commune_residence)
                        <div class="mb-2">
                            <strong><i class="bi bi-geo-alt me-2"></i> Commune de résidence:</strong>
                            {{ $user->commune_residence }}
                        </div>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-2">
                        <strong><i class="bi bi-clock-history me-2"></i> Inscrit le:</strong>
                        {{ $user->created_at->format('d/m/Y à H:i') }}
                    </div>
                    
                    <div class="mb-2">
                        <strong><i class="bi bi-clock me-2"></i> Dernière mise à jour:</strong>
                        {{ $user->updated_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Reservations -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Réservations de l'utilisateur</h6>
                </div>
                <div class="card-body">
                    @if($user->reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="reservationsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>Destination</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->code_reservation }}</td>
                                            <td>{{ $reservation->date_depart->format('d/m/Y') }}</td>
                                            <td>
                                                @if($reservation->type_destination === 'national')
                                                    @php
                                                        $dest = App\Models\DestinationNational::with(['lieuDepart', 'lieuArrive'])->find($reservation->destination_id);
                                                    @endphp
                                                    @if($dest && $dest->lieuDepart && $dest->lieuArrive)
                                                        {{ $dest->lieuDepart->ville }} - {{ $dest->lieuArrive->ville }}
                                                    @else
                                                        Destination inconnue
                                                    @endif
                                                @else
                                                    @php
                                                        $dest = App\Models\DestinationSousRegion::find($reservation->destination_id);
                                                    @endphp
                                                    @if($dest)
                                                        Côte d'Ivoire - {{ $dest->pays_destination }} ({{ $dest->ville_destination }})
                                                    @else
                                                        Destination inconnue
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ number_format($reservation->total, 0, ',', ' ') }} CFA</td>
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
                            <p class="mt-3">Aucune réservation trouvée pour cet utilisateur.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            @if($user->type === 'Sous-Traitant' && $user->sousTraitant)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations du Sous-Traitant</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Type:</strong> {{ $user->sousTraitant->type === 'personne_physique' ? 'Personne physique' : 'Personne morale' }}</p>
                                
                                @if($user->sousTraitant->nom_commercial)
                                    <p><strong>Nom commercial:</strong> {{ $user->sousTraitant->nom_commercial }}</p>
                                @endif
                                
                                @if($user->sousTraitant->forme_juridique)
                                    <p><strong>Forme juridique:</strong> {{ $user->sousTraitant->forme_juridique }}</p>
                                @endif
                                
                                @if($user->sousTraitant->capital)
                                    <p><strong>Capital:</strong> {{ number_format($user->sousTraitant->capital, 0, ',', ' ') }} CFA</p>
                                @endif
                                
                                <p><strong>Commune d'activité:</strong> {{ $user->sousTraitant->commune_activite }}</p>
                            </div>
                            
                            <div class="col-md-6">
                                @if($user->sousTraitant->rccm)
                                    <p><strong>RCCM:</strong> {{ $user->sousTraitant->rccm }}</p>
                                @endif
                                
                                @if($user->sousTraitant->compte_contribuable)
                                    <p><strong>Compte contribuable:</strong> {{ $user->sousTraitant->compte_contribuable }}</p>
                                @endif
                                
                                <p><strong>Taux de commission:</strong> {{ $user->sousTraitant->taux_commission }}%</p>
                                
                                @if($user->sousTraitant->montant_cautionnement)
                                    <p><strong>Cautionnement:</strong> {{ number_format($user->sousTraitant->montant_cautionnement, 0, ',', ' ') }} CFA</p>
                                @endif
                                
                                <p><strong>Statut:</strong> 
                                    @if($user->sousTraitant->est_actif)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('soustraitants.show', $user->sousTraitant->id) }}" class="btn btn-primary btn-sm">
                                Voir détails du sous-traitant
                            </a>
                        </div>
                    </div>
                </div>
            @endif
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
            order: [[1, 'desc']]
        });
    });
</script>
@endpush