@extends('layouts.app')

@section('title', 'Modifier un Utilisateur | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier l'Utilisateur</h1>
        <div>
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Voir détails
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification d'utilisateur</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Type Utilisateur -->
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type d'utilisateur <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="Administrateur" {{ old('type', $user->type) == 'Administrateur' ? 'selected' : '' }}>Administrateur</option>
                            <option value="Voyageur" {{ old('type', $user->type) == 'Voyageur' ? 'selected' : '' }}>Voyageur</option>
                            <option value="Sous-Traitant" {{ old('type', $user->type) == 'Sous-Traitant' ? 'selected' : '' }}>Sous-Traitant</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rôle -->
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{ old('role', $user->role) }}">
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-3">
                        <label for="contact_telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('contact_telephone') is-invalid @enderror" name="contact_telephone" id="contact_telephone" value="{{ old('contact_telephone', $user->contact_telephone) }}" required>
                        @error('contact_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- WhatsApp -->
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}">
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date de naissance -->
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $user->date_naissance ? $user->date_naissance->format('Y-m-d') : '') }}">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <!-- Commune de résidence -->
                    <label for="commune_residence" class="form-label">Commune de résidence</label>
                    <input type="text" class="form-control @error('commune_residence') is-invalid @enderror" name="commune_residence" id="commune_residence" value="{{ old('commune_residence', $user->commune_residence) }}">
                    @error('commune_residence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Mot de passe -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                        <div class="form-text">Laissez vide pour conserver le mot de passe actuel.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmation du nouveau mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
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