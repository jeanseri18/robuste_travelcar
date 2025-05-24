@extends('layouts.app')

@section('title', 'Détails Réservation | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de la Réservation</h1>
        <div>
            <div class="btn-group me-2">
                @if($reservation->statut === 'en_attente')
                    <form action="{{ route('reservations.confirmer', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirmer
                        </button>
                    </form>
                @endif
                
                @if($reservation->statut !== 'annulee')
                    <form action="{{ route('reservations.annuler', $reservation->id) }}" method="POST" class="ms-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                            <i class="bi bi-x-circle"></i> Annuler
                        </button>
                    </form>
                @endif
            </div>
            
            <div class="btn-group">
                <!-- <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Modifier
                </a> -->
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la Réservation</h6>
                    <div>
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Référence: {{ $reservation->code_reservation }}</h5>
                            <p class="text-muted">
                                Réservation créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Total: {{ number_format($reservation->total, 0, ',', ' ') }} CFA</h5>
                            <p class="text-muted">
                                @if($reservation->paiement)
                                    @switch($reservation->paiement->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning">Paiement en attente</span>
                                            @break
                                        @case('complete')
                                            <span class="badge bg-success">Paiement complété</span>
                                            @break
                                        @case('echoue')
                                            <span class="badge bg-danger">Paiement échoué</span>
                                            @break
                                        @case('remboursement')
                                            <span class="badge bg-info">Paiement remboursé</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $reservation->paiement->statut }}</span>
                                    @endswitch
                                @else
                                    <span class="badge bg-secondary">Non payé</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="font-weight-bold">Informations du Client</h6>
                                <p>
                                    <strong>Nom:</strong> 
                                    <a href="{{ route('users.show', $reservation->user->id) }}">
                                        {{ $reservation->user->nom }} {{ $reservation->user->prenom }}
                                    </a>
                                </p>
                                <p>
                                    <strong>Email:</strong> 
                                    <a href="mailto:{{ $reservation->user->email }}">{{ $reservation->user->email }}</a>
                                </p>
                                <p>
                                    <strong>Téléphone:</strong> 
                                    <a href="tel:{{ $reservation->user->contact_telephone }}">{{ $reservation->user->contact_telephone }}</a>
                                </p>
                                
                                @if($reservation->nom_voyageur || $reservation->contact_voyageur)
                                    <h6 class="font-weight-bold mt-3">Informations du Voyageur</h6>
                                    @if($reservation->nom_voyageur)
                                        <p><strong>Nom:</strong> {{ $reservation->nom_voyageur }}</p>
                                    @endif
                                    @if($reservation->contact_voyageur)
                                        <p>
                                            <strong>Téléphone:</strong> 
                                            <a href="tel:{{ $reservation->contact_voyageur }}">{{ $reservation->contact_voyageur }}</a>
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="font-weight-bold">Détails du Voyage</h6>
                                <p>
                                    <strong>Société:</strong> 
                                    <a href="{{ route('societes.show', $reservation->societe->id) }}">
                                        {{ $reservation->societe->nom_commercial }}
                                    </a>
                                </p>
                                <p>
                                    <strong>Gare de départ:</strong> 
                                    <a href="{{ route('gares.show', $reservation->gare->id) }}">
                                        {{ $reservation->gare->nom_gare }}
                                    </a>
                                </p>
                                <p>
                                    <strong>Lieu d'embarquement:</strong> {{ $reservation->lieu_embarquement }}
                                </p>
                                <p>
                                    <strong>Date de départ:</strong> {{ $reservation->date_depart->format('d/m/Y') }}
                                </p>
                                <p>
                                    <strong>Heure de départ:</strong> {{ substr($reservation->heure_depart, 0, 5) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6 class="font-weight-bold">Destination</h6>
                            <div class="card mb-4">
                                <div class="card-body">
                                    @if($reservation->type_destination === 'national')
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>
                                                    @if($destination && $destination->lieuDepart && $destination->lieuArrive)
                                                        {{ $destination->lieuDepart->ville }} → {{ $destination->lieuArrive->ville }}
                                                    @else
                                                        Destination nationale
                                                    @endif
                                                </h5>
                                                <p class="text-muted">
                                                    @if($destination && $destination->lieuDepart && $destination->lieuArrive)
                                                        @if($destination->lieuDepart->commune)
                                                            {{ $destination->lieuDepart->commune }}
                                                        @endif
                                                        →
                                                        @if($destination->lieuArrive->commune)
                                                            {{ $destination->lieuArrive->commune }}
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <p>
                                                    <strong>Tarif unitaire:</strong> {{ number_format($reservation->tarif_unitaire, 0, ',', ' ') }} CFA
                                                </p>
                                                <p>
                                                    <strong>Nombre de tickets:</strong> {{ $reservation->nombre_tickets }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>
                                                    @if($destination)
                                                        Côte d'Ivoire → {{ $destination->pays_destination }}
                                                    @else
                                                        Destination sous-régionale
                                                    @endif
                                                </h5>
                                                <p class="text-muted">
                                                    @if($destination)
                                                        {{ $destination->ville_destination }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <p>
                                                    <strong>Tarif unitaire:</strong> {{ number_format($reservation->tarif_unitaire, 0, ',', ' ') }} CFA
                                                </p>
                                                <p>
                                                    <strong>Nombre de tickets:</strong> {{ $reservation->nombre_tickets }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Options</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Assurance voyageur
                                    @if($reservation->assurance_voyageur)
                                        <span class="badge bg-success">Oui</span>
                                    @else
                                        <span class="badge bg-secondary">Non</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Assurance bagages
                                    @if($reservation->assurance_bagages)
                                        <span class="badge bg-success">Oui</span>
                                    @else
                                        <span class="badge bg-secondary">Non</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Coût des assurances
                                    <span>{{ number_format($reservation->cout_assurance, 0, ',', ' ') }} CFA</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Récapitulatif</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sous-total
                                    <span>{{ number_format($reservation->tarif_unitaire * $reservation->nombre_tickets, 0, ',', ' ') }} CFA</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Assurances
                                    <span>{{ number_format($reservation->cout_assurance, 0, ',', ' ') }} CFA</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                    Total
                                    <span>{{ number_format($reservation->total, 0, ',', ' ') }} CFA</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    @if($reservation->commentaire)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="font-weight-bold">Commentaire</h6>
                            <div class="card mb-4">
                                <div class="card-body">
                                    {{ $reservation->commentaire }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Paiement -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Paiement</h6>
                </div>
                <div class="card-body">
                    @if($reservation->paiement)
                        <div class="mb-3">
                            <h5>
                                @switch($reservation->paiement->statut)
                                    @case('en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                        @break
                                    @case('complete')
                                        <span class="badge bg-success">Complété</span>
                                        @break
                                    @case('echoue')
                                        <span class="badge bg-danger">Échoué</span>
                                        @break
                                    @case('remboursement')
                                        <span class="badge bg-info">Remboursé</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $reservation->paiement->statut }}</span>
                                @endswitch
                            </h5>
                            
                            <p class="mb-0">
                                <strong>Date:</strong> {{ $reservation->paiement->date_paiement ? $reservation->paiement->date_paiement->format('d/m/Y H:i') : 'Non spécifiée' }}
                            </p>
                            <p class="mb-0">
                                <strong>Montant:</strong> {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} CFA
                            </p>
                            <p class="mb-0">
                                <strong>Méthode:</strong> 
                                @switch($reservation->paiement->methode)
                                    @case('orange_money')
                                        Orange Money
                                        @break
                                    @case('mtn_money')
                                        MTN Money
                                        @break
                                    @case('moov_money')
                                        Moov Money
                                        @break
                                    @case('wave')
                                        Wave
                                        @break
                                    @case('cheque')
                                        Chèque
                                        @break
                                    @case('virement')
                                        Virement bancaire
                                        @break
                                            @case('espece')
espece                                        @break
    @case('cinetpay')
via  cinepay                                        @break
                                    @default
                                        {{ $reservation->paiement->methode }}
                                @endswitch
                            </p>
                            
                            @if($reservation->paiement->numero_transaction)
                                <p class="mb-0">
                                    <strong>Numéro de transaction:</strong> {{ $reservation->paiement->numero_transaction }}
                                </p>
                            @endif
                            
                            @if($reservation->paiement->reference_transaction)
                                <p class="mb-0">
                                    <strong>Référence:</strong> {{ $reservation->paiement->reference_transaction }}
                                </p>
                            @endif
                            
                            @if($reservation->paiement->commentaire)
                                <p class="mb-0">
                                    <strong>Commentaire:</strong> {{ $reservation->paiement->commentaire }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('paiements.edit', $reservation->paiement->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Modifier le paiement
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-credit-card" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-3">Aucun paiement enregistré pour cette réservation.</p>
                            
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('paiements.create', ['reservation' => $reservation->id]) }}" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i> Enregistrer un paiement
                                </a>
                            </div>
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
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Imprimer la réservation
                        </button>
<!--                         
                        <a href="#" class="btn btn-info">
                            <i class="bi bi-envelope"></i> Envoyer par email
                        </a> -->
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Supprimer
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
                    Êtes-vous sûr de vouloir supprimer la réservation <strong>{{ $reservation->code_reservation }}</strong> ?
                    <br>
                    Cette action est irréversible et supprimera également le paiement associé.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection