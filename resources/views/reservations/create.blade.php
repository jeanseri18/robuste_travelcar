@extends('layouts.app')

@section('title', 'Créer une Réservation | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer une Réservation</h1>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création de réservation</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Client -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">Client <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id" required>
                            <option value="" selected disabled>Sélectionnez un client</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                        <select class="form-select @error('type_destination') is-invalid @enderror" name="type_destination" id="type_destination" required>
                            <option value="" selected disabled>Sélectionnez un type</option>
                            <option value="national" {{ old('type_destination') == 'national' ? 'selected' : '' }}>Nationale</option>
                            <option value="sousregion" {{ old('type_destination') == 'sousregion' ? 'selected' : '' }}>Sous-régionale</option>
                        </select>
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
                            <option value="" selected disabled>Sélectionnez une société</option>
                            @foreach($societes as $societe)
                                <option value="{{ $societe->id }}" {{ old('societe_id') == $societe->id ? 'selected' : '' }}>
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
                    </select>
                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Date de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="date_depart" class="form-label">Date de départ <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_depart') is-invalid @enderror" name="date_depart" id="date_depart" value="{{ old('date_depart', date('Y-m-d')) }}" required>
                        @error('date_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Heure de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="heure_depart" class="form-label">Heure de départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('heure_depart') is-invalid @enderror" name="heure_depart" id="heure_depart" value="{{ old('heure_depart') }}" required>
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
                            <input type="number" class="form-control @error('tarif_unitaire') is-invalid @enderror" name="tarif_unitaire" id="tarif_unitaire" value="{{ old('tarif_unitaire') }}" required readonly>
                            <span class="input-group-text">CFA</span>
                        </div>
                        @error('tarif_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nombre de tickets -->
                    <div class="col-md-4 mb-3">
                        <label for="nombre_tickets" class="form-label">Nombre de tickets <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nombre_tickets') is-invalid @enderror" name="nombre_tickets" id="nombre_tickets" value="{{ old('nombre_tickets', 1) }}" min="1" required>
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
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lieu_embarquement_type" id="lieu_embarquement_gare" value="gare" checked>
                        <label class="form-check-label" for="lieu_embarquement_gare">
                            À la gare
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lieu_embarquement_type" id="lieu_embarquement_trajet" value="trajet">
                        <label class="form-check-label" for="lieu_embarquement_trajet">
                            Sur le trajet
                        </label>
                    </div>
                    <div id="lieu_embarquement_details" class="mt-2 d-none">
                        <input type="text" class="form-control @error('lieu_embarquement') is-invalid @enderror" name="lieu_embarquement" id="lieu_embarquement" value="{{ old('lieu_embarquement') }}" placeholder="Précisez le lieu d'embarquement">
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
                                    <input class="form-check-input" type="checkbox" name="assurance_voyageur" id="assurance_voyageur" value="1" {{ old('assurance_voyageur') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assurance_voyageur">
                                        Assurance voyageur (2 000 CFA)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="assurance_bagages" id="assurance_bagages" value="1" {{ old('assurance_bagages') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assurance_bagages">
                                        Assurance bagages (1 500 CFA)
                                    </label>
                                </div>
                                <input type="hidden" name="cout_assurance" id="cout_assurance" value="{{ old('cout_assurance', 0) }}">
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="mb-0">Coût total assurance: <span id="cout_assurance_display">0</span> CFA</p>
                                <p class="mb-0">Total à payer: <span id="total_final">0</span> CFA</p>
                            </div>
                        </div>
                    </div>
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
                                <input type="text" class="form-control @error('nom_voyageur') is-invalid @enderror" name="nom_voyageur" id="nom_voyageur" value="{{ old('nom_voyageur') }}">
                                @error('nom_voyageur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_voyageur" class="form-label">Contact du voyageur</label>
                                <input type="text" class="form-control @error('contact_voyageur') is-invalid @enderror" name="contact_voyageur" id="contact_voyageur" value="{{ old('contact_voyageur') }}">
                                @error('contact_voyageur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                        <i class="bi bi-save"></i> Créer la réservation
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
                lieuEmbarquementInput.value = "";
                lieuEmbarquementInput.focus();
            }
        });

        // Initialisation du lieu d'embarquement
        if (lieuEmbarquementTypeGare.checked) {
            lieuEmbarquementInput.value = "A la gare";
        }

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

        // Chargement des gares en fonction de la société
        const societeSelect = document.getElementById('societe_id');
        const gareSelect = document.getElementById('gare_depart');
        const destinationSelect = document.getElementById('destination_id');
        const typeDestinationSelect = document.getElementById('type_destination');
        const horaireInfo = document.getElementById('horaires_info');

        societeSelect.addEventListener('change', function() {
            const societeId = this.value;
            if (!societeId) return;

            // Vider les sélecteurs de gare et destination
// Suite du script JavaScript dans reservations/create.blade.php
            // Vider les sélecteurs de gare et destination
            gareSelect.innerHTML = '<option value="" selected disabled>Sélectionnez une gare</option>';
            destinationSelect.innerHTML = '<option value="" selected disabled>Sélectionnez une destination</option>';
            tarifUnitaire.value = '';
            calculerTotal();

            // Charger les gares de la société
            fetch(`/api/societes/${societeId}/gares`)
                .then(response => response.json())
                .then(gares => {
                    gares.forEach(gare => {
                        const option = document.createElement('option');
                        option.value = gare.id;
                        option.textContent = gare.nom_gare;
                        gareSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des gares:', error));
        });

        // Chargement des destinations en fonction de la gare et du type
        gareSelect.addEventListener('change', function() {
            const gareId = this.value;
            const typeDestination = typeDestinationSelect.value;
            const societeId = societeSelect.value;
            
            if (!gareId || !typeDestination || !societeId) return;

            // Vider le sélecteur de destination
            destinationSelect.innerHTML = '<option value="" selected disabled>Sélectionnez une destination</option>';
            tarifUnitaire.value = '';
            horaireInfo.textContent = '';
            calculerTotal();

            // Charger les destinations
            fetch(`/api/destinations/${typeDestination}/${societeId}?gare=${gareId}`)
                .then(response => response.json())
                .then(destinations => {
                    destinations.forEach(destination => {
                        const option = document.createElement('option');
                        option.value = destination.id;
                        
                        if (typeDestination === 'national') {
                            const departVille = destination.lieu_depart ? destination.lieu_depart.ville : 'N/A';
                            const arriveVille = destination.lieu_arrive ? destination.lieu_arrive.ville : 'N/A';
                            option.textContent = `${departVille} → ${arriveVille} (${destination.tarif_unitaire} CFA)`;
                        } else {
                            option.textContent = `CDI → ${destination.pays_destination} - ${destination.ville_destination} (${destination.tarif_unitaire} CFA)`;
                        }
                        
                        // Stocker les données supplémentaires comme attributs data-*
                        option.dataset.tarif = destination.tarif_unitaire;
                        option.dataset.premierDepart = destination.premier_depart;
                        option.dataset.dernierDepart = destination.dernier_depart;
                        
                        destinationSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des destinations:', error));
        });

        // Mise à jour du tarif et des informations d'horaires lors de la sélection d'une destination
        destinationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;
            
            tarifUnitaire.value = selectedOption.dataset.tarif;
            
            // Afficher les informations d'horaires
            const premierDepart = selectedOption.dataset.premierDepart.substring(0, 5);
            const dernierDepart = selectedOption.dataset.dernierDepart.substring(0, 5);
            horaireInfo.textContent = `Horaires disponibles: ${premierDepart} - ${dernierDepart}`;
            
            calculerTotal();
        });

        // Initialiser le type de destination et les champs d'assurance
        typeDestinationSelect.dispatchEvent(new Event('change'));
        calculerCoutAssurance();
    });
</script>
@endpush