@extends('layouts.app')

@section('title', 'Modifier une Société | TravelCar225')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-building-gear text-primary me-2"></i>
                Modifier une Société de Transport
            </h1>
            <p class="text-muted mb-0">Modifiez les informations de la société sélectionnée</p>
        </div>
        <div>
            <a href="{{ route('societes.show', $societe->id) }}" class="btn btn-outline-info me-2">
                <i class="bi bi-eye me-1"></i> Voir détails
            </a>
            <a href="{{ route('societes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-primary py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="bi bi-form me-2"></i>
                Formulaire de modification de société
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('societes.update', $societe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Informations principales -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informations principales</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nom commercial -->
                            <div class="col-md-6 mb-3">
                                <label for="nom_commercial" class="form-label">Nom commercial <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom_commercial') is-invalid @enderror" name="nom_commercial" id="nom_commercial" value="{{ old('nom_commercial', $societe->nom_commercial) }}" required>
                                @error('nom_commercial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Forme juridique -->
                            <div class="col-md-6 mb-3">
                                <label for="forme_juridique" class="form-label">Forme juridique</label>
                                <select class="form-select @error('forme_juridique') is-invalid @enderror" name="forme_juridique" id="forme_juridique">
                                    <option value="" selected disabled>Sélectionnez une forme juridique</option>
                                    <option value="Entreprise individuelle" {{ old('forme_juridique', $societe->forme_juridique) == 'Entreprise individuelle' ? 'selected' : '' }}>Entreprise individuelle</option>
                                    <option value="SARL U" {{ old('forme_juridique', $societe->forme_juridique) == 'SARL U' ? 'selected' : '' }}>SARL U</option>
                                    <option value="SARL PL" {{ old('forme_juridique', $societe->forme_juridique) == 'SARL PL' ? 'selected' : '' }}>SARL PL</option>
                                    <option value="SA" {{ old('forme_juridique', $societe->forme_juridique) == 'SA' ? 'selected' : '' }}>SA</option>
                                    <option value="Autre" {{ old('forme_juridique', $societe->forme_juridique) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('forme_juridique')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Siège social -->
                            <div class="col-md-6 mb-3">
                                <label for="siege_social" class="form-label">Siège social</label>
                                <input type="text" class="form-control @error('siege_social') is-invalid @enderror" name="siege_social" id="siege_social" value="{{ old('siege_social', $societe->siege_social) }}">
                                @error('siege_social')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de création -->
                            <div class="col-md-6 mb-3">
                                <label for="date_creation" class="form-label">Date de création</label>
                                <input type="date" class="form-control @error('date_creation') is-invalid @enderror" name="date_creation" id="date_creation" value="{{ old('date_creation', $societe->date_creation ? $societe->date_creation->format('Y-m-d') : '') }}">
                                @error('date_creation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Capital -->
                            <div class="col-md-6 mb-3">
                                <label for="capital" class="form-label">Capital (CFA)</label>
                                <input type="number" min="0" step="1000" class="form-control @error('capital') is-invalid @enderror" name="capital" id="capital" value="{{ old('capital', $societe->capital) }}">
                                @error('capital')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Logo -->
                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <div class="mb-2">
                                    @if($societe->logo)
                                        <img src="{{ asset('storage/' . $societe->logo) }}" alt="{{ $societe->nom_commercial }}" width="100" class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_logo" id="remove_logo" value="1">
                                            <label class="form-check-label" for="remove_logo">
                                                Supprimer le logo actuel
                                            </label>
                                        </div>
                                    @else
                                        Aucun logo
                                    @endif
                                </div>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo">
                                <div class="form-text">Format recommandé: 200x200 px, PNG ou JPG</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations administratives -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informations administratives</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- RCCM -->
                            <div class="col-md-6 mb-3">
                                <label for="rccm" class="form-label">Numéro RCCM</label>
                                <input type="text" class="form-control @error('rccm') is-invalid @enderror" name="rccm" id="rccm" value="{{ old('rccm', $societe->rccm) }}">
                                @error('rccm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Compte contribuable -->
                            <div class="col-md-6 mb-3">
                                <label for="compte_contribuable" class="form-label">Compte contribuable</label>
                                <input type="text" class="form-control @error('compte_contribuable') is-invalid @enderror" name="compte_contribuable" id="compte_contribuable" value="{{ old('compte_contribuable', $societe->compte_contribuable) }}">
                                @error('compte_contribuable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Régime d'imposition -->
                            <div class="col-md-6 mb-3">
                                <label for="regime_imposition" class="form-label">Régime d'imposition</label>
                                <input type="text" class="form-control @error('regime_imposition') is-invalid @enderror" name="regime_imposition" id="regime_imposition" value="{{ old('regime_imposition', $societe->regime_imposition) }}">
                                @error('regime_imposition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Centre des impôts -->
                            <div class="col-md-6 mb-3">
                                <label for="centre_impots" class="form-label">Centre des impôts</label>
                                <input type="text" class="form-control @error('centre_impots') is-invalid @enderror" name="centre_impots" id="centre_impots" value="{{ old('centre_impots', $societe->centre_impots) }}">
                                @error('centre_impots')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Compte bancaire -->
                        <div class="mb-3">
                            <label for="compte_bancaire" class="form-label">Compte bancaire</label>
                            <input type="text" class="form-control @error('compte_bancaire') is-invalid @enderror" name="compte_bancaire" id="compte_bancaire" value="{{ old('compte_bancaire', $societe->compte_bancaire) }}">
                            @error('compte_bancaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Coordonnées -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Coordonnées</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Adresse -->
                            <div class="col-md-12 mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" id="adresse" value="{{ old('adresse', $societe->adresse) }}">
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $societe->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone', $societe->telephone) }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- WhatsApp -->
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $societe->whatsapp) }}">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Responsable marketing -->
                            <div class="col-md-6 mb-3">
                                <label for="responsable_marketing" class="form-label">Responsable marketing</label>
                                <input type="text" class="form-control @error('responsable_marketing') is-invalid @enderror" name="responsable_marketing" id="responsable_marketing" value="{{ old('responsable_marketing', $societe->responsable_marketing) }}">
                                @error('responsable_marketing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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