@extends('layouts.auth')

@section('title', 'Création de compte Administrateur | TravelCar225')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh; padding: 40px 0;">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('logo.png') }}" alt="TravelCar225 Logo" width="150">
                        <h2 class="mt-3">Création de compte Administrateur</h2>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf

                        <div class="row">
                            <!-- Nom Field -->
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                    name="nom" id="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Prénom Field -->
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                    name="prenom" id="prenom" value="{{ old('prenom') }}">
                                @error('prenom')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email Field -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" id="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Téléphone Field -->
                            <div class="col-md-6 mb-3">
                                <label for="contact_telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_telephone') is-invalid @enderror" 
                                    name="contact_telephone" id="contact_telephone" value="{{ old('contact_telephone') }}" required>
                                @error('contact_telephone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password Field -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" id="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmation du mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                    name="password_confirmation" id="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                                Créer le compte
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <p>Vous avez déjà un compte? <a href="{{ route('admin.login.form') }}" class="text-decoration-none">Connectez-vous</a></p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3 text-white">
                <p>TravelCar225 &copy; {{ date('Y') }} - Tous droits réservés</p>
            </div>
        </div>
    </div>
</div>
@endsection