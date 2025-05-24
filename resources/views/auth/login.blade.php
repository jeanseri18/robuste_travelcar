@extends('layouts.auth')

@section('title', 'Connexion | TravelCar225')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('logo.png') }}" alt="TravelCar225 Logo" width="150">
                        <h2 class="mt-3">Connexion Administrateur</h2>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
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

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" id="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" 
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                                Se connecter
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('auth.password.request') }}" class="text-decoration-none">
                            Mot de passe oublié ?
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