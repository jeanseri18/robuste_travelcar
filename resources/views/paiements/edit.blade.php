@extends('layouts.app')

@section('title', 'Modifier un Paiement | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier un Paiement</h1>
        <div>
            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Voir détails
            </a>
            <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification de paiement</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('paiements.update', $paiement->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Détails de la réservation -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Détails de la réservation</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5 class="mb-1">Réservation associée</h5>
                            <p class="mb-1">Code: <strong>{{ $paiement->reservation->code_reservation }}</strong></p>
                            <p class="mb-1">Client: <strong>{{ $paiement->reservation->user->nom }} {{ $paiement->reservation->user->prenom }}</strong></p>
                            <p class="mb-0">Montant total: <strong>{{ number_format($paiement->reservation->total, 0, ',', ' ') }} CFA</strong></p>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('reservations.show', $paiement->reservation->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Voir la réservation
                            </a>
                        </div>
                        
                        <!-- Champ caché pour la réservation -->
                        <input type="hidden" name="reservation_id" value="{{ $paiement->reservation_id }}">
                    </div>
                </div>

                <!-- Informations de paiement -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informations de paiement</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Montant -->
                            <div class="col-md-6 mb-3">
                                <label for="montant" class="form-label">Montant (CFA) <span class="text-danger">*</span></label>
                                <input type="number" min="0" step="100" class="form-control @error('montant') is-invalid @enderror" name="montant" id="montant" value="{{ old('montant', $paiement->montant) }}" required>
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Méthode de paiement -->
                            <div class="col-md-6 mb-3">
                                <label for="methode" class="form-label">Méthode de paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('methode') is-invalid @enderror" name="methode" id="methode" required>
                                    <option value="orange_money" {{ old('methode', $paiement->methode) == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                                    <option value="mtn_money" {{ old('methode', $paiement->methode) == 'mtn_money' ? 'selected' : '' }}>MTN Money</option>
                                    <option value="moov_money" {{ old('methode', $paiement->methode) == 'moov_money' ? 'selected' : '' }}>Moov Money</option>
                                    <option value="wave" {{ old('methode', $paiement->methode) == 'wave' ? 'selected' : '' }}>Wave</option>
                                    <option value="cheque" {{ old('methode', $paiement->methode) == 'cheque' ? 'selected' : '' }}>Chèque</option>
                                    <option value="virement" {{ old('methode', $paiement->methode) == 'virement' ? 'selected' : '' }}>Virement</option>
                                    <option value="espece" {{ old('methode', $paiement->methode) == 'espece' ? 'selected' : '' }}>Espèce</option>
                                    <option value="cinetpay" {{ old('methode', $paiement->methode) == 'cinetpay' ? 'selected' : '' }}>CinetPay</option>
                                </select>
                                @error('methode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Numéro de transaction -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_transaction" class="form-label">Numéro de transaction</label>
                                <input type="text" class="form-control @error('numero_transaction') is-invalid @enderror" name="numero_transaction" id="numero_transaction" value="{{ old('numero_transaction', $paiement->numero_transaction) }}">
                                @error('numero_transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Référence de transaction -->
                            <div class="col-md-6 mb-3">
                                <label for="reference_transaction" class="form-label">Référence de transaction</label>
                                <input type="text" class="form-control @error('reference_transaction') is-invalid @enderror" name="reference_transaction" id="reference_transaction" value="{{ old('reference_transaction', $paiement->reference_transaction) }}">
                                @error('reference_transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut du paiement <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                                <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="complete" {{ old('statut', $paiement->statut) == 'complete' ? 'selected' : '' }}>Complété</option>
                                <option value="echoue" {{ old('statut', $paiement->statut) == 'echoue' ? 'selected' : '' }}>Échoué</option>
                                <option value="remboursement" {{ old('statut', $paiement->statut) == 'remboursement' ? 'selected' : '' }}>Remboursement</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commentaire -->
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire</label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire" rows="3">{{ old('commentaire', $paiement->commentaire) }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informations CinetPay (si applicable) -->
                        @if($paiement->methode === 'cinetpay' && ($paiement->cinetpay_transaction_id || $paiement->cinetpay_operator_id))
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-credit-card"></i> Informations CinetPay
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($paiement->cinetpay_transaction_id)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">ID Transaction CinetPay:</small>
                                        <div class="fw-bold">{{ $paiement->cinetpay_transaction_id }}</div>
                                    </div>
                                    @endif
                                    @if($paiement->cinetpay_operator_id)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">ID Opérateur:</small>
                                        <div class="fw-bold">{{ $paiement->cinetpay_operator_id }}</div>
                                    </div>
                                    @endif
                                    @if($paiement->cinetpay_payment_method)
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Méthode de paiement CinetPay:</small>
                                        <div class="fw-bold">{{ $paiement->cinetpay_payment_method }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                        <i class="bi bi-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statutSelect = document.getElementById('statut');
        const originalStatus = '{{ $paiement->statut }}';
        
        statutSelect.addEventListener('change', function() {
            if (this.value !== originalStatus && (this.value === 'complete' || this.value === 'echoue' || this.value === 'remboursement')) {
                const currentStatus = this.value === 'complete' ? 'confirmée' : 
                                     (this.value === 'echoue' ? 'en attente' : 'annulée');
                
                alert(`Attention: La modification du statut de paiement à "${this.options[this.selectedIndex].text}" entraînera la mise à jour du statut de la réservation associée à "${currentStatus}".`);
            }
        });
    });
</script>
@endpush