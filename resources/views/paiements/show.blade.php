@extends('layouts.app')

@section('title', 'Détails Paiement | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du Paiement</h1>
        <div>
            <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
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
        <!-- Informations du paiement -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du Paiement</h6>
                    <div>
                        @switch($paiement->statut)
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
                                <span class="badge bg-info">Remboursement</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $paiement->statut }}</span>
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Montant: {{ number_format($paiement->montant, 0, ',', ' ') }} CFA</h5>
                        <p class="text-muted">
                            Paiement réalisé le {{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y à H:i') : $paiement->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Méthode de paiement</h6>
                        <p>
                            <i class="bi bi-credit-card me-2"></i> 
                            @switch($paiement->methode)
                                @case('orange_money')
                                    <strong>Orange Money</strong>
                                    @break
                                @case('mtn_money')
                                    <strong>MTN Money</strong>
                                    @break
                                @case('moov_money')
                                    <strong>Moov Money</strong>
                                    @break
                                @case('wave')
                                    <strong>Wave</strong>
                                    @break
                                @case('cheque')
                                    <strong>Chèque</strong>
                                    @break
                                @case('virement')
                                    <strong>Virement bancaire</strong>
                                    @break
                                @default
                                    <strong>{{ $paiement->methode }}</strong>
                            @endswitch
                        </p>
                        
                        @if($paiement->numero_transaction)
                            <p>
                                <i class="bi bi-upc me-2"></i> <strong>Numéro de transaction:</strong> {{ $paiement->numero_transaction }}
                            </p>
                        @endif
                        
                        @if($paiement->reference_transaction)
                            <p>
                                <i class="bi bi-hash me-2"></i> <strong>Référence:</strong> {{ $paiement->reference_transaction }}
                            </p>
                        @endif
                    </div>
                    
                    @if($paiement->commentaire)
                        <hr>
                        
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Commentaire</h6>
                            <p>{{ $paiement->commentaire }}</p>
                        </div>
                    @endif
                    
                    <hr>
                    
                    <div>
                        <p>
                            <i class="bi bi-person me-2"></i> <strong>Client:</strong> 
                            <a href="{{ route('users.show', $paiement->user->id) }}">
                                {{ $paiement->user->nom }} {{ $paiement->user->prenom }}
                            </a>
                        </p>
                        <p>
                            <i class="bi bi-calendar-check me-2"></i> <strong>Réservation:</strong> 
                            <a href="{{ route('reservations.show', $paiement->reservation->id) }}">
                                {{ $paiement->reservation->code_reservation }}
                            </a>
                        </p>
                    </div>
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
                            <i class="bi bi-printer"></i> Imprimer la facture
                        </button>
                        
                        <a href="#" class="btn btn-info">
                            <i class="bi bi-envelope"></i> Envoyer par email
                        </a>
                        
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Supprimer ce paiement
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Détails de la réservation -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Détails de la Réservation</h6>
                    <div>
                        @switch($paiement->reservation->statut)
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
                                <span class="badge bg-secondary">{{ $paiement->reservation->statut }}</span>
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Référence: {{ $paiement->reservation->code_reservation }}</h5>
                        <p class="text-muted">
                            Réservation créée le {{ $paiement->reservation->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
<h6 class="font-weight-bold">Détails du trajet</h6>
                        <p>
                            <strong>Départ:</strong> {{ $paiement->reservation->gare->nom ?? $paiement->reservation->gare_depart }}
                        </p>
                        <p>
                            <strong>Lieu d'embarquement:</strong> {{ $paiement->reservation->lieu_embarquement }}
                        </p>
                        <p>
                            <strong>Date et heure:</strong> {{ $paiement->reservation->date_depart->format('d/m/Y') }} à {{ $paiement->reservation->heure_depart->format('H:i') }}
                        </p>
                        
                        @if($paiement->reservation->nom_voyageur)
                            <p>
                                <strong>Voyageur:</strong> {{ $paiement->reservation->nom_voyageur }}
                                @if($paiement->reservation->contact_voyageur)
                                    ({{ $paiement->reservation->contact_voyageur }})
                                @endif
                            </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Informations de la compagnie</h6>
                        <p>
                            <i class="bi bi-building me-2"></i> 
                            <strong>Compagnie:</strong> 
                            <a href="{{ route('societes.show', $paiement->reservation->societe->id) }}">
                                {{ $paiement->reservation->societe->nom }}
                            </a>
                        </p>
                        
                        @if($paiement->reservation->type_destination)
                            <p>
                                <i class="bi bi-geo-alt me-2"></i> 
                                <strong>Type de destination:</strong> 
                                {{ $paiement->reservation->type_destination === 'national' ? 'National' : 'Sous-région' }}
                            </p>
                        @endif
                        
                        @if($paiement->reservation->destination)
                            <p>
                                <i class="bi bi-pin-map me-2"></i> 
                                <strong>Destination:</strong> 
                                {{ $paiement->reservation->destination->nom ?? 'N/A' }}
                            </p>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Détails du tarif</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Prix unitaire</td>
                                        <td class="text-end">{{ number_format($paiement->reservation->tarif_unitaire, 0, ',', ' ') }} CFA</td>
                                    </tr>
                                    <tr>
                                        <td>Nombre de tickets</td>
                                        <td class="text-end">{{ $paiement->reservation->nombre_tickets }}</td>
                                    </tr>
                                    @if($paiement->reservation->assurance_voyageur || $paiement->reservation->assurance_bagages)
                                        <tr>
                                            <td>
                                                Assurance 
                                                @if($paiement->reservation->assurance_voyageur && $paiement->reservation->assurance_bagages)
                                                    (voyageur et bagages)
                                                @elseif($paiement->reservation->assurance_voyageur)
                                                    (voyageur)
                                                @elseif($paiement->reservation->assurance_bagages)
                                                    (bagages)
                                                @endif
                                            </td>
                                            <td class="text-end">{{ number_format($paiement->reservation->cout_assurance, 0, ',', ' ') }} CFA</td>
                                        </tr>
                                    @endif
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td class="text-end">{{ number_format($paiement->reservation->total, 0, ',', ' ') }} CFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($paiement->reservation->commentaire)
                        <hr>
                        
                        <div>
                            <h6 class="font-weight-bold">Commentaire réservation</h6>
                            <p>{{ $paiement->reservation->commentaire }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce paiement ?</p>
                <p class="text-danger">
                    <i class="bi bi-exclamation-triangle"></i> 
                    Cette action est irréversible et affectera le statut de la réservation associée.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts supplémentaires pour cette vue -->
@push('scripts')
<script>
    // Script pour impression formatée
    function beforePrint() {
        // Masquer les éléments qui ne doivent pas être imprimés
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = 'none';
        });
    }
    
    function afterPrint() {
        // Restaurer l'affichage normal après impression
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = '';
        });
    }
    
    if (window.matchMedia) {
        const mediaQueryList = window.matchMedia('print');
        mediaQueryList.addEventListener('change', event => {
            if (!event.matches) {
                afterPrint();
            } else {
                beforePrint();
            }
        });
    }
    
    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;
</script>
@endpush
@endsection