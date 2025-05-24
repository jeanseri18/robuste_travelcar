@extends('layouts.app')

@section('title', 'Modifier une Destination Sous-régionale | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier une Destination Sous-régionale</h1>
        <div>
            <a href="{{ route('destinations_sousregion.show', $destination->id) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Voir détails
            </a>
            <a href="{{ route('destinations_sousregion.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification de destination sous-régionale</h6>
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
                        <input type="text" class="form-control @error('ville_destination') is-invalid @enderror" name="ville_destination" id="ville_destination" value="{{ old('ville_destination', $destination->ville_destination) }}" required>
                        @error('ville_destination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
    });
</script>
@endpush