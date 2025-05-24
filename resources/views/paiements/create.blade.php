@extends('layouts.app')

@section('title', 'Enregistrer un Paiement | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Enregistrer un Paiement</h1>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'enregistrement de paiement</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('paiements.store') }}" method="POST">
                @csrf

                <!-- Sélection de la réservation -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Sélection de la réservation</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="reservation_id" class="form-label">Réservation <span class="text-danger">*</span></label>
                            <select class="form-select @error('reservation_id') is-invalid @enderror" name="reservation_id" id="reservation_id" required>
                                <option value="" selected disabled>Sélectionnez une réservation</option>
                                @foreach($reservations as $reservation)
                                    <option value="{{ $reservation->id }}" 
                                            data-total="{{ $reservation->total }}"
                                            data-code="{{ $reservation->code_reservation }}"
                                            data-client="{{ $reservation->user->nom }} {{ $reservation->user->prenom }}"
                                            {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}>
                                        {{ $reservation->code_reservation }} - {{ $reservation->user->nom }} {{ $reservation->user->prenom }} - {{ number_format($reservation->total, 0, ',', ' ') }} CFA
                                    </option>
                                @endforeach
                            </select>
                            @error('reservation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="reservationDetails" class="mt-3 d-none">
                            <div class="alert alert-info">
                                <h5 class="mb-1">Détails de la réservation</h5>
                                <p class="mb-1">Code: <strong id="reservationCode"></strong></p>
                                <p class="mb-1">Client: <strong id="reservationClient"></strong></p>
                                <p class="mb-0">Montant total: <strong id="reservationTotal"></strong> CFA</p>
                            </div>
                        </div>
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
                                <input type="number" min="0" step="100" class="form-control @error('montant') is-invalid @enderror" name="montant" id="montant" value="{{ old('montant') }}" required>
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Méthode de paiement -->
                            <div class="col-md-6 mb-3">
                                <label for="methode" class="form-label">Méthode de paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('methode') is-invalid @enderror" name="methode" id="methode" required>
                                    <option value="" selected disabled>Sélectionnez une méthode</option>
                                    <option value="orange_money" {{ old('methode') == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                                    <option value="mtn_money" {{ old('methode') == 'mtn_money' ? 'selected' : '' }}>MTN Money</option>
                                    <option value="moov_money" {{ old('methode') == 'moov_money' ? 'selected' : '' }}>Moov Money</option>
                                    <option value="wave" {{ old('methode') == 'wave' ? 'selected' : '' }}>Wave</option>
                                    <option value="cheque" {{ old('methode') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                                    <option value="virement" {{ old('methode') == 'virement' ? 'selected' : '' }}>Virement</option>
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
                                <input type="text" class="form-control @error('numero_transaction') is-invalid @enderror" name="numero_transaction" id="numero_transaction" value="{{ old('numero_transaction') }}">
                                @error('numero_transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Référence de transaction -->
                            <div class="col-md-6 mb-3">
                                <label for="reference_transaction" class="form-label">Référence de transaction</label>
                                <input type="text" class="form-control @error('reference_transaction') is-invalid @enderror" name="reference_transaction" id="reference_transaction" value="{{ old('reference_transaction') }}">
                                @error('reference_transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut du paiement <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                                <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="complete" {{ old('statut') == 'complete' ? 'selected' : '' }}>Complété</option>
                                <option value="echoue" {{ old('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
                                <option value="remboursement" {{ old('statut') == 'remboursement' ? 'selected' : '' }}>Remboursement</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commentaire -->
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire</label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire" rows="3">{{ old('commentaire') }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                        <i class="bi bi-save"></i> Enregistrer le paiement
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
        const reservationSelect = document.getElementById('reservation_id');
        const montantInput = document.getElementById('montant');
        const reservationDetails = document.getElementById('reservationDetails');
        const reservationCode = document.getElementById('reservationCode');
        const reservationClient = document.getElementById('reservationClient');
        const reservationTotal = document.getElementById('reservationTotal');

        reservationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) {
                reservationDetails.classList.add('d-none');
                return;
            }

            // Mise à jour des détails de la réservation
            const total = selectedOption.dataset.total;
            const code = selectedOption.dataset.code;
            const client = selectedOption.dataset.client;
            
            reservationCode.textContent = code;
            reservationClient.textContent = client;
            reservationTotal.textContent = new Intl.NumberFormat('fr-FR').format(total);
            
            // Pré-remplir le montant avec le total de la réservation
            montantInput.value = total;
            
            // Afficher les détails
            reservationDetails.classList.remove('d-none');
        });

        // Initialiser si une réservation est déjà sélectionnée
        if (reservationSelect.value) {
            reservationSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush