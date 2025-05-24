@extends('layouts.app')

@section('title', 'Modifier une Réservation | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier une Réservation</h1>
        <div>
            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Voir détails
            </a>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification de réservation</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Client -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">Client <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->nom }} {{ $user->prenom }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type de destination -->
                    <div class="col-md-6 mb-3">
                        <label for="type_destination" class="form-label">Type de destination <span class="text-danger">*</span></label>
                        <select class="form-select @error('type_destination') is-invalid @enderror" name="type_destination" id="type_destination" required disabled>
                            <option value="national" {{ old('type_destination', $reservation->type_destination) == 'national' ? 'selected' : '' }}>Nationale</option>
                            <option value="sousregion" {{ old('type_destination', $reservation->type_destination) == 'sousregion' ? 'selected' : '' }}>Sous-régionale</option>
                        </select>
                        <input type="hidden" name="type_destination" value="{{ $reservation->type_destination }}">
                        @error('type_destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Société -->
                    <div class="col-md-6 mb-3">
                        <label for="societe_id" class="form-label">Société <span class="text-danger">*</span></label>
                        <select class="form-select @error('societe_id') is-invalid @enderror" name="societe_id" id="societe_id" required>
                            @foreach($societes as $societe)
                                <option value="{{ $societe->id }}" {{ old('societe_id', $reservation->societe_id) == $societe->id ? 'selected' : '' }}>
                                    {{ $societe->nom_commercial }}
                                </option>
                            @endforeach
                        </select>
                        @error('societe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gare de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="gare_depart" class="form-label">Gare de départ <span class="text-danger">*</span></label>
                        <select class="form-select @error('gare_depart') is-invalid @enderror" name="gare_depart" id="gare_depart" required>
                            <option value="" selected disabled>Sélectionnez une gare</option>
                            @foreach($gares as $gare)
                                <option value="{{ $gare->id }}" {{ old('gare_depart', $reservation->gare_depart) == $gare->id ? 'selected' : '' }}>
                                    {{ $gare->nom_gare }}
                                </option>
                            @endforeach
                        </select>
                        @error('gare_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Destination -->
                <div class="mb-3">
                    <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                    <select class="form-select @error('destination_id') is-invalid @enderror" name="destination_id" id="destination_id" required>
                        <option value="" selected disabled>Sélectionnez une destination</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" 
                                {{ old('destination_id', $reservation->destination_id) == $destination->id ? 'selected' : '' }}
                                data-tarif="{{ $destination->tarif_unitaire }}"
                                data-premier-depart="{{ substr($destination->premier_depart, 0, 5) }}"
                                data-dernier-depart="{{ substr($destination->dernier_depart, 0, 5) }}">
                                @if($reservation->type_destination === 'national')
                                    {{ $destination->lieuDepart->ville ?? 'N/A' }} → {{ $destination->lieuArrive->ville ?? 'N/A' }} ({{ $destination->tarif_unitaire }} CFA)
                                @else
                                    CDI → {{ $destination->pays_destination }} - {{ $destination->ville_destination }} ({{ $destination->tarif_unitaire }} CFA)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Date de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="date_depart" class="form-label">Date de départ <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_depart') is-invalid @enderror" name="date_depart" id="date_depart" value="{{ old('date_depart', $reservation->date_depart->format('Y-m-d')) }}" required>
                        @error('date_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Heure de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="heure_depart" class="form-label">Heure de départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('heure_depart') is-invalid @enderror" name="heure_depart" id="heure_depart" value="{{ old('heure_depart', substr($reservation->heure_depart, 0, 5)) }}" required>
                        @error('heure_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" id="horaires_info"></div>
                    </div>
                </div>

                <div class="row">
                    <!-- Tarif unitaire -->
                    <div class="col-md-4 mb-3">
                        <label for="tarif_unitaire" class="form-label">Tarif unitaire <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('tarif_unitaire') is-invalid @enderror" name="tarif_unitaire" id="tarif_unitaire" value="{{ old('tarif_unitaire', $reservation->tarif_unitaire) }}" required>
                            <span class="input-group-text">CFA</span>
                        </div>
                        @error('tarif_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nombre de tickets -->
                    <div class="col-md-4 mb-3">
                        <label for="nombre_tickets" class="form-label">Nombre de tickets <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nombre_tickets') is-invalid @enderror" name="nombre_tickets" id="nombre_tickets" value="{{ old('nombre_tickets', $reservation->nombre_tickets) }}" min="1" required>
                        @error('nombre_tickets')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Total -->
                    <div class="col-md-4 mb-3">
                        <label for="total_calculé" class="form-label">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="total_calculé" readonly>
                            <span class="input-group-text">CFA</span>
                        </div>
                    </div>
                </div>

                <!-- Lieu d'embarquement -->
                <div class="mb-3">
                    <label for="lieu_embarquement" class="form-label">Lieu d'embarquement <span class="text-danger">*</span></label>
                    @php
                        $isGare = strtolower($reservation->lieu_embarquement) === 'a la gare';
                    @endphp
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lieu_embarquement_type" id="lieu_embarquement_gare" value="gare" {{ $isGare ? 'checked' : '' }}>
                        <label class="form-check-label" for="lieu_embarquement_gare">
                            À la gare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lieu_embarquement_type" id="lieu_embarquement_trajet" value="trajet" {{ !$isGare ? 'checked' : '' }}>
                        <label class="form-check-label" for="lieu_embarquement_trajet">
                            Sur le trajet
                        </label>
                    </div>
                    <div id="lieu_embarquement_details" class="mt-2 {{ $isGare ? 'd-none' : '' }}">
                        <input type="text" class="form-control @error('lieu_embarquement') is-invalid @enderror" name="lieu_embarquement" id="lieu_embarquement" value="{{ old('lieu_embarquement', $reservation->lieu_embarquement) }}" placeholder="Précisez le lieu d'embarquement">
                        @error('lieu_embarquement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Options d'assurance -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Options d'assurance</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="assurance_voyageur" id="assurance_voyageur" value="1" {{ old('assurance_voyageur', $reservation->assurance_voyageur) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assurance_voyageur">
                                        Assurance voyageur (2 000 CFA)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="assurance_bagages" id="assurance_bagages" value="1" {{ old('assurance_bagages', $reservation->assurance_bagages) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assurance_bagages">
                                        Assurance bagages (1 500 CFA)
                                    </label>
                                </div>
                                <input type="hidden" name="cout_assurance" id="cout_assurance" value="{{ old('cout_assurance', $reservation->cout_assurance) }}">
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="mb-0">Coût total assurance: <span id="cout_assurance_display">{{ number_format($reservation->cout_assurance, 0, ',', ' ') }}</span> CFA</p>
                                <p class="mb-0">Total à payer: <span id="total_final">{{ number_format($reservation->total, 0, ',', ' ') }}</span> CFA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statut de la réservation -->
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut de la réservation <span class="text-danger">*</span></label>
                    <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                        <option value="en_attente" {{ old('statut', $reservation->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmee" {{ old('statut', $reservation->statut) == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                        <option value="annulee" {{ old('statut', $reservation->statut) == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Informations complémentaires -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Informations complémentaires</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom_voyageur" class="form-label">Nom du voyageur (si différent du client)</label>
                                <input type="text" class="form-control @error('nom_voyageur') is-invalid @enderror" name="nom_voyageur" id="nom_voyageur" value="{{ old('nom_voyageur', $reservation->nom_voyageur) }}">
                                @error('nom_voyageur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_voyageur" class="form-label">Contact du voyageur</label>
                                <input type="text" class="form-control @error('contact_voyageur') is-invalid @enderror" name="contact_voyageur" id="contact_voyageur" value="{{ old('contact_voyageur', $reservation->contact_voyageur) }}">
                                @error('contact_voyageur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire</label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire" rows="3">{{ old('commentaire', $reservation->commentaire) }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
        // Gestion du lieu d'embarquement
        const lieuEmbarquementTypeGare = document.getElementById('lieu_embarquement_gare');
        const lieuEmbarquementTypeTrajet = document.getElementById('lieu_embarquement_trajet');
        const lieuEmbarquementDetails = document.getElementById('lieu_embarquement_details');
        const lieuEmbarquementInput = document.getElementById('lieu_embarquement');

        lieuEmbarquementTypeGare.addEventListener('change', function() {
            if (this.checked) {
                lieuEmbarquementDetails.classList.add('d-none');
                lieuEmbarquementInput.value = "A la gare";
            }
        });

        lieuEmbarquementTypeTrajet.addEventListener('change', function() {
            if (this.checked) {
                lieuEmbarquementDetails.classList.remove('d-none');
                if (lieuEmbarquementInput.value === "A la gare") {
                    lieuEmbarquementInput.value = "";
                }
                lieuEmbarquementInput.focus();
            }
        });

        // Calcul du coût de l'assurance et du total
        const assuranceVoyageur = document.getElementById('assurance_voyageur');
        const assuranceBagages = document.getElementById('assurance_bagages');
        const coutAssuranceInput = document.getElementById('cout_assurance');
        const coutAssuranceDisplay = document.getElementById('cout_assurance_display');
        const totalFinal = document.getElementById('total_final');
        const tarifUnitaire = document.getElementById('tarif_unitaire');
        const nombreTickets = document.getElementById('nombre_tickets');
        const totalCalculé = document.getElementById('total_calculé');

        function calculerCoutAssurance() {
            let cout = 0;
            if (assuranceVoyageur.checked) cout += 2000;
            if (assuranceBagages.checked) cout += 1500;
            coutAssuranceInput.value = cout;
            coutAssuranceDisplay.textContent = cout.toLocaleString('fr-FR');
            calculerTotal();
        }

        function calculerTotal() {
            const tarif = parseFloat(tarifUnitaire.value) || 0;
            const nombre = parseInt(nombreTickets.value) || 0;
            const sousTotal = tarif * nombre;
            totalCalculé.value = sousTotal.toLocaleString('fr-FR');
            
            const assurance = parseInt(coutAssuranceInput.value) || 0;
            const total = sousTotal + assurance;
            totalFinal.textContent = total.toLocaleString('fr-FR');
        }

        assuranceVoyageur.addEventListener('change', calculerCoutAssurance);
        assuranceBagages.addEventListener('change', calculerCoutAssurance);
        nombreTickets.addEventListener('input', calculerTotal);
        tarifUnitaire.addEventListener('input', calculerTotal);

        // Mise à jour du tarif lors de la sélection d'une destination
        const destinationSelect = document.getElementById('destination_id');
        
        destinationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;
            
            tarifUnitaire.value = selectedOption.dataset.tarif;
            
            // Afficher les informations d'horaires
            const premierDepart = selectedOption.dataset.premierDepart;
            const dernierDepart = selectedOption.dataset.dernierDepart;
            const horaireInfo = document.getElementById('horaires_info');
            horaireInfo.textContent = `Horaires disponibles: ${premierDepart} - ${dernierDepart}`;
            
            calculerTotal();
        });

        // Initialiser les valeurs au chargement
        calculerTotal();
        
        // Déclencher l'événement change sur le select de destination pour afficher les horaires
        if (destinationSelect.value) {
            destinationSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush