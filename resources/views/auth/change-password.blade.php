@extends('layouts.app')

@section('title', 'Changer mon mot de passe | TravelCar225')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Changer mon mot de passe</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.password.update') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <!-- Current Password Field -->
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                        name="current_password" id="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- New Password Field -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="password" id="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Le mot de passe doit contenir au moins 8 caractères.
                                    </div>
                                </div>

                                <!-- Confirm New Password Field -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmation du nouveau mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                        name="password_confirmation" id="password_confirmation" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary" style="background-color:#1088F2; border-color:#1088F2;">
                                        Changer mon mot de passe
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection