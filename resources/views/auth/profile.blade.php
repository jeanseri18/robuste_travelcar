@extends('layouts.app')

@section('title', 'Mon Profil | TravelCar225')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mon Profil</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <div class="avatar-wrapper mb-3">
                                    <i class="bi bi-person-circle" style="font-size: 8rem; color: #1088F2;"></i>
                                </div>
                                <h4>{{ $user->nom }} {{ $user->prenom }}</h4>
                                <p class="text-muted">{{ $user->role }}</p>
                                
                                <a href="{{ route('auth.password.form') }}" class="btn btn-outline-primary mt-2">
                                    <i class="bi bi-lock"></i> Changer de mot de passe
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <form method="POST" action="{{ route('auth.profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Nom Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                            name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required>
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
                                            name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}">
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
                                            name="email" id="email" value="{{ old('email', $user->email) }}" required>
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
                                            name="contact_telephone" id="contact_telephone" value="{{ old('contact_telephone', $user->contact_telephone) }}" required>
                                        @error('contact_telephone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- WhatsApp Field -->
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" 
                                        name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}">
                                    @error('whatsapp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                                        Mettre à jour mon profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection