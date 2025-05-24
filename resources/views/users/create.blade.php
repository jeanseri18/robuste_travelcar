@extends('layouts.app')

@section('title', 'Créer un Utilisateur | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer un Utilisateur</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création d'utilisateur</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Type Utilisateur -->
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type d'utilisateur <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="" selected disabled>Sélectionnez un type</option>
                            <option value="Administrateur" {{ old('type') == 'Administrateur' ? 'selected' : '' }}>Administrateur</option>
                            <option value="Voyageur" {{ old('type') == 'Voyageur' ? 'selected' : '' }}>Voyageur</option>
                            <option value="Sous-Traitant" {{ old('type') == 'Sous-Traitant' ? 'selected' : '' }}>Sous-Traitant</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rôle -->
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{ old('role') }}">
                        <div class="form-text">Laissez vide pour utiliser le type d'utilisateur comme rôle.</div>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" value="{{ old('prenom') }}">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('contact_telephone') is-invalid @enderror" name="contact_telephone" id="contact_telephone" value="{{ old('contact_telephone') }}" required>
                        @error('contact_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- WhatsApp -->
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}">
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date de naissance -->
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <!-- Commune de résidence -->
                    <label for="commune_residence" class="form-label">Commune de résidence</label>
                    <input type="text" class="form-control @error('commune_residence') is-invalid @enderror" name="commune_residence" id="commune_residence" value="{{ old('commune_residence') }}">
                    @error('commune_residence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Mot de passe -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                        <div class="form-text">Le mot de passe doit contenir au moins 8 caractères.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmation du mot de passe <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                        <i class="bi bi-person-plus"></i> Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection