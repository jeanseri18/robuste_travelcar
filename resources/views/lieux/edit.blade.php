@extends('layouts.app')

@section('title', 'Modifier un Lieu | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-pencil-square text-warning me-2"></i>
                Modifier un Lieu
            </h1>
            <p class="text-muted mb-0">Modifiez les informations du lieu sélectionné</p>
        </div>
        <div>
            <a href="{{ route('lieux.show', $lieu->id) }}" class="btn btn-outline-info me-2">
                <i class="bi bi-eye me-1"></i> Voir détails
            </a>
            <a href="{{ route('lieux.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-warning py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="bi bi-form me-2"></i>
                Formulaire de modification de lieu
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lieux.update', $lieu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Ville -->
                    <div class="col-md-6 mb-3">
                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ville') is-invalid @enderror" name="ville" id="ville" value="{{ old('ville', $lieu->ville) }}" required>
                        @error('ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commune -->
                    <div class="col-md-6 mb-3">
                        <label for="commune" class="form-label">Commune</label>
                        <input type="text" class="form-control @error('commune') is-invalid @enderror" name="commune" id="commune" value="{{ old('commune', $lieu->commune) }}">
                        @error('commune')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Région -->
                    <div class="col-md-4 mb-3">
                        <label for="region" class="form-label">Région</label>
                        <input type="text" class="form-control @error('region') is-invalid @enderror" name="region" id="region" value="{{ old('region', $lieu->region) }}">
                        @error('region')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Département -->
                    <div class="col-md-4 mb-3">
                        <label for="departement" class="form-label">Département</label>
                        <input type="text" class="form-control @error('departement') is-invalid @enderror" name="departement" id="departement" value="{{ old('departement', $lieu->departement) }}">
                        @error('departement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sous-préfecture -->
                    <div class="col-md-4 mb-3">
                        <label for="sous_prefecture" class="form-label">Sous-préfecture</label>
                        <input type="text" class="form-control @error('sous_prefecture') is-invalid @enderror" name="sous_prefecture" id="sous_prefecture" value="{{ old('sous_prefecture', $lieu->sous_prefecture) }}">
                        @error('sous_prefecture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label class="form-label">Type de lieu <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_depart" value="depart" {{ old('type', $lieu->type) == 'depart' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_depart">Lieu de départ uniquement</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_arrive" value="arrive" {{ old('type', $lieu->type) == 'arrive' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_arrive">Lieu d'arrivée uniquement</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_les_deux" value="les_deux" {{ old('type', $lieu->type) == 'les_deux' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_les_deux">Lieu de départ et d'arrivée</label>
                    </div>
                    @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('est_actif') is-invalid @enderror" name="est_actif" id="est_actif" value="1" {{ old('est_actif', $lieu->est_actif) ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_actif">Lieu actif</label>
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