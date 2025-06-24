@extends('layouts.app')

@section('title', 'Modifier une Destination Sous-régionale | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                Modifier une Destination Sous-régionale
            </h1>
            <p class="text-muted mb-0">Modifiez les informations de la destination sélectionnée</p>
        </div>
        <div>
            <a href="{{ route('destinations_sousregion.show', $destination->id) }}" class="btn btn-outline-info me-2">
                <i class="bi bi-eye me-1"></i> Voir détails
            </a>
            <a href="{{ route('destinations_sousregion.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-danger py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="bi bi-form me-2"></i>
                Formulaire de modification de destination sous-régionale
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('destinations_sousregion.update', $destination->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Société -->
                    <div class="col-md-6 mb-3">
                        <label for="societe_id" class="form-label">Société <span class="text-danger">*</span></label>
                        <select class="form-select @error('societe_id') is-invalid @enderror" name="societe_id" id="societe_id" required>
                            @foreach($societes as $societe)
                                <option value="{{ $societe->id }}" {{ old('societe_id', $destination->societe_id) == $societe->id ? 'selected' : '' }}>
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
                            @foreach($gares as $gare)
                                <option value="{{ $gare->id }}" {{ old('gare_depart', $destination->gare_depart) == $gare->id ? 'selected' : '' }}>
                                    {{ $gare->nom_gare }}
                                </option>
                            @endforeach
                        </select>
                        @error('gare_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Pays de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="pays_depart" class="form-label">Pays de départ <span class="text-danger">*</span></label>
                        <select class="form-select @error('pays_depart') is-invalid @enderror" name="pays_depart" id="pays_depart" required>
                            <option value="" disabled>Sélectionnez un pays</option>
                            @foreach($pays as $p)
                                <option value="{{ $p }}" {{ old('pays_depart', $destination->pays_depart) == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                        @error('pays_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ville de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="ville_depart" class="form-label">Ville de départ <span class="text-danger">*</span></label>
                        <select class="form-select @error('ville_depart') is-invalid @enderror" name="ville_depart" id="ville_depart" required>
                            <option value="" disabled>Sélectionnez d'abord un pays</option>
                        </select>
                        @error('ville_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Pays de destination -->
                    <div class="col-md-6 mb-3">
                        <label for="pays_destination" class="form-label">Pays de destination <span class="text-danger">*</span></label>
                        <select class="form-select @error('pays_destination') is-invalid @enderror" name="pays_destination" id="pays_destination" required>
                            @foreach($pays as $p)
                                <option value="{{ $p }}" {{ old('pays_destination', $destination->pays_destination) == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                        @error('pays_destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ville de destination -->
                    <div class="col-md-6 mb-3">
                        <label for="ville_destination" class="form-label">Ville de destination <span class="text-danger">*</span></label>
                        <select class="form-select @error('ville_destination') is-invalid @enderror" name="ville_destination" id="ville_destination" required>
                            <option value="" selected disabled>Chargement des villes...</option>
                        </select>
                        <div class="form-text">Les villes sont chargées automatiquement selon le pays sélectionné</div>
                        @error('ville_destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Informations du lieu sélectionné -->
                <div id="lieu-info" class="alert alert-info" style="display: none;">
                    <h6><i class="bi bi-info-circle"></i> Informations du lieu</h6>
                    <div id="lieu-details"></div>
                </div>

                <!-- Adresse de destination -->
                <div class="mb-3">
                    <label for="adresse_destination" class="form-label">Adresse de destination</label>
                    <input type="text" class="form-control @error('adresse_destination') is-invalid @enderror" name="adresse_destination" id="adresse_destination" value="{{ old('adresse_destination', $destination->adresse_destination) }}">
                    @error('adresse_destination')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Tarif unitaire -->
                    <div class="col-md-4 mb-3">
                        <label for="tarif_unitaire" class="form-label">Tarif unitaire (CFA) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="500" class="form-control @error('tarif_unitaire') is-invalid @enderror" name="tarif_unitaire" id="tarif_unitaire" value="{{ old('tarif_unitaire', $destination->tarif_unitaire) }}" required>
                        @error('tarif_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Premier départ -->
                    <div class="col-md-4 mb-3">
                        <label for="premier_depart" class="form-label">Premier départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('premier_depart') is-invalid @enderror" name="premier_depart" id="premier_depart" value="{{ old('premier_depart', substr($destination->premier_depart, 0, 5)) }}" required>
                        @error('premier_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dernier départ -->
                    <div class="col-md-4 mb-3">
                        <label for="dernier_depart" class="form-label">Dernier départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('dernier_depart') is-invalid @enderror" name="dernier_depart" id="dernier_depart" value="{{ old('dernier_depart', substr($destination->dernier_depart, 0, 5)) }}" required>
                        @error('dernier_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Capacité bus -->
                    <div class="col-md-6 mb-3">
                        <label for="capacite_bus" class="form-label">Capacité des bus</label>
                        <input type="number" min="1" class="form-control @error('capacite_bus') is-invalid @enderror" name="capacite_bus" id="capacite_bus" value="{{ old('capacite_bus', $destination->capacite_bus) }}">
                        <div class="form-text">Nombre de passagers par bus</div>
                        @error('capacite_bus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Durée du trajet -->
                    <div class="col-md-6 mb-3">
                        <label for="duree_trajet" class="form-label">Durée du trajet (en heures)</label>
                        <input type="number" min="0" step="0.5" class="form-control @error('duree_trajet') is-invalid @enderror" name="duree_trajet" id="duree_trajet" value="{{ old('duree_trajet', $destination->duree_trajet) }}">
                        <div class="form-text">Durée approximative du voyage</div>
                        @error('duree_trajet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('est_actif') is-invalid @enderror" name="est_actif" id="est_actif" value="1" {{ old('est_actif', $destination->est_actif) ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_actif">Destination active</label>
                    @error('est_actif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
        // Chargement des gares en fonction de la société
        const societeSelect = document.getElementById('societe_id');
        const gareSelect = document.getElementById('gare_depart');
        const paysDepartSelect = document.getElementById('pays_depart');
        const villeDepartSelect = document.getElementById('ville_depart');
        const paysSelect = document.getElementById('pays_destination');
        const villeSelect = document.getElementById('ville_destination');

        societeSelect.addEventListener('change', function() {
            const societeId = this.value;
            if (!societeId) return;

            // Réinitialiser les sélecteurs
            gareSelect.innerHTML = '<option value="" selected disabled>Chargement des gares...</option>';

            // Charger les gares de la société
            fetch(`/api/societes/${societeId}/gares`)
                .then(response => response.json())
                .then(gares => {
                    gareSelect.innerHTML = '<option value="" selected disabled>Sélectionnez une gare</option>';
                    gares.forEach(gare => {
                        const option = document.createElement('option');
                        option.value = gare.id;
                        option.textContent = gare.nom_gare;
                        gareSelect.appendChild(option);
                    });
                    
                    // Restaurer la valeur sélectionnée si présente
                    const previousValue = "{{ old('gare_depart', $destination->gare_depart) }}";
                    if (previousValue) {
                        gareSelect.value = previousValue;
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des gares:', error));
        });

        // Déclencher le chargement initial si nécessaire
        if (societeSelect.value && !window.initialLoadDone) {
            window.initialLoadDone = true;
            societeSelect.dispatchEvent(new Event('change'));
        }

        // Gestion dynamique des villes
        const lieuInfo = document.getElementById('lieu-info');
        const lieuDetails = document.getElementById('lieu-details');

        // Fonction générique pour charger les villes en fonction du pays et du type
        function chargerVilles(paysSelectElement, villeSelectElement, type = null, villeSelectionnee = null, afficherLieuInfo = false) {
            const pays = paysSelectElement.value;
            if (!pays) {
                villeSelectElement.innerHTML = '<option value="" selected disabled>Sélectionnez d\'abord un pays</option>';
                return;
            }

            // Réinitialiser le sélecteur de ville
            villeSelectElement.innerHTML = '<option value="" selected disabled>Chargement des villes...</option>';
            if (afficherLieuInfo && lieuInfo) {
                lieuInfo.style.display = 'none';
            }

            // Construire l'URL avec le paramètre type si spécifié
            let url = `/api/lieux/villes-par-pays/${encodeURIComponent(pays)}`;
            if (type) {
                url += `?type=${type}`;
            }

            // Charger les villes du pays depuis les lieux
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        villeSelectElement.innerHTML = `<option value="" selected disabled>${data.error}</option>`;
                        return;
                    }
                    
                    villeSelectElement.innerHTML = '<option value="" selected disabled>Sélectionnez une ville</option>';
                    
                    if (data.villes && data.villes.length > 0) {
                        data.villes.forEach(ville => {
                            const option = document.createElement('option');
                            option.value = ville;
                            option.textContent = ville;
                            if (villeSelectionnee && ville === villeSelectionnee) {
                                option.selected = true;
                            }
                            villeSelectElement.appendChild(option);
                        });
                        
                        // Si une ville était présélectionnée et qu'on doit afficher les infos du lieu
                        if (villeSelectionnee && afficherLieuInfo) {
                            // Attendre un peu que l'option soit sélectionnée
                            setTimeout(() => {
                                if (villeSelectElement.value === villeSelectionnee) {
                                    afficherInfosLieu(pays, villeSelectionnee);
                                }
                            }, 100);
                        }
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucune ville trouvée pour ce pays';
                        option.disabled = true;
                        villeSelectElement.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des villes:', error);
                    villeSelectElement.innerHTML = '<option value="" selected disabled>Erreur de chargement des villes</option>';
                });
        }

        // Chargement des villes de départ en fonction du pays de départ
        paysDepartSelect.addEventListener('change', function() {
            chargerVilles(paysDepartSelect, villeDepartSelect, 'depart');
        });

        // Chargement initial des villes de départ si un pays est déjà sélectionné
        if (paysDepartSelect.value) {
            const villeSelectionnee = "{{ old('ville_depart', $destination->ville_depart) }}";
            chargerVilles(paysDepartSelect, villeDepartSelect, 'depart', villeSelectionnee);
        }

        // Chargement des villes de destination en fonction du pays de destination
        paysSelect.addEventListener('change', function() {
            chargerVilles(paysSelect, villeSelect, 'arrive', null, true);
        });

        // Chargement initial des villes de destination si un pays est déjà sélectionné
        if (paysSelect.value) {
            const villeSelectionnee = "{{ old('ville_destination', $destination->ville_destination) }}";
            chargerVilles(paysSelect, villeSelect, 'arrive', villeSelectionnee, true);
        }

        // Gestion des informations du lieu pour la destination

        // Fonction pour afficher les informations du lieu
        function afficherInfosLieu(pays, ville) {
            if (!pays || !ville || !lieuInfo || !lieuDetails) {
                if (lieuInfo) lieuInfo.style.display = 'none';
                return;
            }

            fetch(`/api/lieux/details?pays=${encodeURIComponent(pays)}&ville=${encodeURIComponent(ville)}`)
                .then(response => response.json())
                .then(lieu => {
                    if (lieu) {
                        lieuDetails.innerHTML = `
                            <div class="row">
                                <div class="col-md-3"><strong>Ville:</strong> ${lieu.ville}</div>
                                <div class="col-md-3"><strong>Pays:</strong> ${lieu.pays}</div>
                                <div class="col-md-3"><strong>Région:</strong> ${lieu.region || 'Non spécifiée'}</div>
                                <div class="col-md-3"><strong>Type:</strong> ${lieu.type || 'Non spécifié'}</div>
                            </div>
                        `;
                        lieuInfo.style.display = 'block';
                    } else {
                        lieuInfo.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des détails du lieu:', error);
                    lieuInfo.style.display = 'none';
                });
        }

        // Événement pour afficher les informations du lieu de destination
        villeSelect.addEventListener('change', function() {
            const pays = paysSelect.value;
            const ville = this.value;
            afficherInfosLieu(pays, ville);
        });
    });
</script>
@endpush