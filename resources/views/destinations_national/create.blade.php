@extends('layouts.app')

@section('title', 'Créer une Destination Nationale | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer une Destination Nationale</h1>
        <a href="{{ route('destinations_national.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création de destination nationale</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('destinations_national.store') }}" method="POST">
                @csrf

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
                            <option value="" selected disabled>Sélectionnez d'abord une société</option>
                        </select>
                        @error('gare_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Lieu de départ -->
                    <div class="col-md-6 mb-3">
                        <label for="depart" class="form-label">Lieu de départ <span class="text-danger">*</span></label>
                        <select class="form-select @error('depart') is-invalid @enderror" name="depart" id="depart" required>
                            <option value="" selected disabled>Chargement des lieux...</option>
                        </select>
                        @error('depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu d'arrivée -->
                    <div class="col-md-6 mb-3">
                        <label for="arrive" class="form-label">Lieu d'arrivée <span class="text-danger">*</span></label>
                        <select class="form-select @error('arrive') is-invalid @enderror" name="arrive" id="arrive" required>
                            <option value="" selected disabled>Chargement des lieux...</option>
                        </select>
                        @error('arrive')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Tarif unitaire -->
                    <div class="col-md-4 mb-3">
                        <label for="tarif_unitaire" class="form-label">Tarif unitaire (CFA) <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="500" class="form-control @error('tarif_unitaire') is-invalid @enderror" name="tarif_unitaire" id="tarif_unitaire" value="{{ old('tarif_unitaire') }}" required>
                        @error('tarif_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Premier départ -->
                    <div class="col-md-4 mb-3">
                        <label for="premier_depart" class="form-label">Premier départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('premier_depart') is-invalid @enderror" name="premier_depart" id="premier_depart" value="{{ old('premier_depart') }}" required>
                        @error('premier_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dernier départ -->
                    <div class="col-md-4 mb-3">
                        <label for="dernier_depart" class="form-label">Dernier départ <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('dernier_depart') is-invalid @enderror" name="dernier_depart" id="dernier_depart" value="{{ old('dernier_depart') }}" required>
                        @error('dernier_depart')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Capacité bus -->
                    <div class="col-md-6 mb-3">
                        <label for="capacite_bus" class="form-label">Capacité des bus</label>
                        <input type="number" min="1" class="form-control @error('capacite_bus') is-invalid @enderror" name="capacite_bus" id="capacite_bus" value="{{ old('capacite_bus') }}">
                        <div class="form-text">Nombre de passagers par bus</div>
                        @error('capacite_bus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fréquence départs -->
                    <div class="col-md-6 mb-3">
                        <label for="frequence_departs" class="form-label">Fréquence des départs (en minutes)</label>
                        <input type="number" min="0" class="form-control @error('frequence_departs') is-invalid @enderror" name="frequence_departs" id="frequence_departs" value="{{ old('frequence_departs') }}">
                        <div class="form-text">Temps entre deux départs successifs</div>
                        @error('frequence_departs')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('est_actif') is-invalid @enderror" name="est_actif" id="est_actif" value="1" {{ old('est_actif', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_actif">Destination active</label>
                    @error('est_actif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                        <i class="bi bi-save"></i> Créer la destination
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
        const departSelect = document.getElementById('depart');
        const arriveSelect = document.getElementById('arrive');

        societeSelect.addEventListener('change', function() {
            const societeId = this.value;
            if (!societeId) return;

            // Réinitialiser les sélecteurs
            gareSelect.innerHTML = '<option value="" selected disabled>Chargement des gares...</option>';
            departSelect.innerHTML = '<option value="" selected disabled>Sélectionnez d\'abord une gare</option>';
            arriveSelect.innerHTML = '<option value="" selected disabled>Sélectionnez d\'abord une gare</option>';

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
                })
                .catch(error => console.error('Erreur lors du chargement des gares:', error));
        });

        // Chargement des lieux de départ et d'arrivée
        gareSelect.addEventListener('change', function() {
            if (!this.value) return;

            // Réinitialiser les sélecteurs
            departSelect.innerHTML = '<option value="" selected disabled>Chargement des lieux...</option>';
            arriveSelect.innerHTML = '<option value="" selected disabled>Chargement des lieux...</option>';

            // Charger les lieux
            fetch('/api/gares-lieux')
                .then(response => response.json())
                .then(data => {
                    // Lieux de départ
                    departSelect.innerHTML = '<option value="" selected disabled>Sélectionnez un lieu de départ</option>';
                    data.depart.forEach(lieu => {
                        const option = document.createElement('option');
                        option.value = lieu.id;
                        option.textContent = lieu.ville + (lieu.commune ? ' - ' + lieu.commune : '');
                        departSelect.appendChild(option);
                    });

                    // Lieux d'arrivée
                    arriveSelect.innerHTML = '<option value="" selected disabled>Sélectionnez un lieu d\'arrivée</option>';
                    data.arrive.forEach(lieu => {
                        const option = document.createElement('option');
                        option.value = lieu.id;
                        option.textContent = lieu.ville + (lieu.commune ? ' - ' + lieu.commune : '');
                        arriveSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des lieux:', error));
        });

        // Si une société est déjà sélectionnée (en cas d'erreur de validation)
        if (societeSelect.value) {
            societeSelect.dispatchEvent(new Event('change'));
            
            // Si une gare est déjà sélectionnée
            setTimeout(() => {
                const gareId = "{{ old('gare_depart') }}";
                if (gareId) {
                    gareSelect.value = gareId;
                    gareSelect.dispatchEvent(new Event('change'));
                    
                    // Si un lieu de départ et d'arrivée sont déjà sélectionnés
                    setTimeout(() => {
                        const departId = "{{ old('depart') }}";
                        const arriveId = "{{ old('arrive') }}";
                        if (departId) departSelect.value = departId;
                        if (arriveId) arriveSelect.value = arriveId;
                    }, 500);
                }
            }, 500);
        }
    });
</script>
@endpush