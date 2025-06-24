@extends('layouts.app')

@section('title', 'Modifier une Gare | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-train-front text-info me-2"></i>
                Modifier une Gare
            </h1>
            <p class="text-muted mb-0">Modifiez les informations de la gare sélectionnée</p>
        </div>
        <div>
            <a href="{{ route('gares.show', $gare->id) }}" class="btn btn-outline-info me-2">
                <i class="bi bi-eye me-1"></i> Voir détails
            </a>
            <a href="{{ route('gares.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-info py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="bi bi-form me-2"></i>
                Formulaire de modification de gare
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('gares.update', $gare->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Société -->
                    <div class="col-md-6 mb-3">
                        <label for="societe_id" class="form-label">Société <span class="text-danger">*</span></label>
                        <select class="form-select @error('societe_id') is-invalid @enderror" name="societe_id" id="societe_id" required>
                            @foreach($societes as $societe)
                                <option value="{{ $societe->id }}" {{ old('societe_id', $gare->societe_id) == $societe->id ? 'selected' : '' }}>
                                    {{ $societe->nom_commercial }}
                                </option>
                            @endforeach
                        </select>
                        @error('societe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nom de la Gare -->
                    <div class="col-md-6 mb-3">
                        <label for="nom_gare" class="form-label">Nom de la Gare <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom_gare') is-invalid @enderror" name="nom_gare" id="nom_gare" value="{{ old('nom_gare', $gare->nom_gare) }}" required>
                        @error('nom_gare')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Ville -->
                    <div class="col-md-6 mb-3">
                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ville') is-invalid @enderror" name="ville" id="ville" value="{{ old('ville', $gare->ville) }}" required>
                        @error('ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commune -->
                    <div class="col-md-6 mb-3">
                        <label for="commune" class="form-label">Commune</label>
                        <input type="text" class="form-control @error('commune') is-invalid @enderror" name="commune" id="commune" value="{{ old('commune', $gare->commune) }}">
                        @error('commune')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <!-- Adresse -->
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" id="adresse" value="{{ old('adresse', $gare->adresse) }}">
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Responsable -->
                    <div class="col-md-6 mb-3">
                        <label for="responsable" class="form-label">Responsable</label>
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror" name="responsable" id="responsable" value="{{ old('responsable', $gare->responsable) }}">
                        @error('responsable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone', $gare->telephone) }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('est_actif') is-invalid @enderror" name="est_actif" id="est_actif" value="1" {{ old('est_actif', $gare->est_actif) ? 'checked' : '' }}>
                    <label class="form-check-label" for="est_actif">Gare active</label>
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