@extends('layouts.app')

@section('title', 'Créer un Lieu | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer un Lieu</h1>
        <a href="{{ route('lieux.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création de lieu</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lieux.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Ville -->
                    <div class="col-md-6 mb-3">
                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ville') is-invalid @enderror" name="ville" id="ville" value="{{ old('ville') }}" required>
                        @error('ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commune -->
                    <div class="col-md-6 mb-3">
                        <label for="commune" class="form-label">Commune</label>
                        <input type="text" class="form-control @error('commune') is-invalid @enderror" name="commune" id="commune" value="{{ old('commune') }}">
                        @error('commune')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Région -->
                    <div class="col-md-4 mb-3">
                        <label for="region" class="form-label">Région</label>
                        <input type="text" class="form-control @error('region') is-invalid @enderror" name="region" id="region" value="{{ old('region') }}">
                        @error('region')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Département -->
                    <div class="col-md-4 mb-3">
                        <label for="departement" class="form-label">Département</label>
                        <input type="text" class="form-control @error('departement') is-invalid @enderror" name="departement" id="departement" value="{{ old('departement') }}">
                        @error('departement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sous-préfecture -->
                    <div class="col-md-4 mb-3">
                        <label for="sous_prefecture" class="form-label">Sous-préfecture</label>
                        <input type="text" class="form-control @error('sous_prefecture') is-invalid @enderror" name="sous_prefecture" id="sous_prefecture" value="{{ old('sous_prefecture') }}">
                        @error('sous_prefecture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label class="form-label">Type de lieu <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_depart" value="depart" {{ old('type') == 'depart' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_depart">Lieu de départ uniquement</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_arrive" value="arrive" {{ old('type') == 'arrive' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_arrive">Lieu d'arrivée uniquement</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input @error('type') is-invalid @enderror" name="type" id="type_les_deux" value="les_deux" {{ old('type', 'les_deux') == 'les_deux' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_les_deux">Lieu de départ et d'arrivée</label>
                    </div>
                    @error('type')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('est_actif') is-invalid @enderror" name="est_actif" id="est_actif" value="1" {{ old('est_actif', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_actif">Lieu actif</label>
                    @error('est_actif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                        <i class="bi bi-save"></i> Créer le lieu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection