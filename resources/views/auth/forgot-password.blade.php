@extends('layouts.auth')

@section('title', 'Récupération de mot de passe | TravelCar225')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('logo.png') }}" alt="TravelCar225 Logo" width="150">
                        <h2 class="mt-3">Récupération de mot de passe</h2>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" id="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                                Envoyer le lien de réinitialisation
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.login.form') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Retour à la connexion
                        </a>
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