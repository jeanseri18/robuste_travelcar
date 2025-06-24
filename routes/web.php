<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\GareController;
use App\Http\Controllers\LieuController;
use App\Http\Controllers\DestinationNationalController;
use App\Http\Controllers\DestinationSousRegionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SousTraitantController;
use App\Http\Controllers\LigneSousTraitantController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes protégées par l'authentification
Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('admin/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::put('admin/profile', [AuthController::class, 'updateProfile'])->name('auth.profile.update');
    
    // Changement de mot de passe
    Route::get('admin/change-password', [AuthController::class, 'showChangePasswordForm'])->name('auth.password.form');
    Route::post('admin/change-password', [AuthController::class, 'changePassword'])->name('auth.password.update');
});

// Routes de récupération de mot de passe
Route::get('admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('auth.password.request');
// Routes d'authentification
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Sociétés
    Route::get('societes', [SocieteController::class, 'index'])->name('societes.index');
    Route::get('societes_create', [SocieteController::class, 'create'])->name('societes.create');
    Route::post('societes', [SocieteController::class, 'store'])->name('societes.store');
    Route::get('societes/{societe}', [SocieteController::class, 'show'])->name('societes.show');
    Route::get('societes_edit/{societe}', [SocieteController::class, 'edit'])->name('societes.edit');
    Route::put('societes/{societe}', [SocieteController::class, 'update'])->name('societes.update');
    Route::delete('societes/{societe}', [SocieteController::class, 'destroy'])->name('societes.destroy');
    Route::get('societes-gare/{societe}/gares', [SocieteController::class, 'getGares'])->name('societes.getGares');
    Route::get('societes-gares', [SocieteController::class, 'garesAll'])->name('societes.garesAll');
    
    // Gares
    Route::get('gares', [GareController::class, 'index'])->name('gares.index');
    Route::get('gares_create', [GareController::class, 'create'])->name('gares.create');
    Route::post('gares', [GareController::class, 'store'])->name('gares.store');
    Route::get('gares/{gare}', [GareController::class, 'show'])->name('gares.show');
    Route::get('gares_edit/{gare}', [GareController::class, 'edit'])->name('gares.edit');
    Route::put('gares/{gare}', [GareController::class, 'update'])->name('gares.update');
    Route::delete('gares/{gare}', [GareController::class, 'destroy'])->name('gares.destroy');
    
    // Lieux
    Route::get('lieux', [LieuController::class, 'index'])->name('lieux.index');
    Route::get('lieux_create', [LieuController::class, 'create'])->name('lieux.create');
    Route::post('lieux', [LieuController::class, 'store'])->name('lieux.store');
    Route::get('lieux/{lieu}', [LieuController::class, 'show'])->name('lieux.show');
    Route::get('lieux_edit/{lieu}', [LieuController::class, 'edit'])->name('lieux.edit');
    Route::put('lieux/{lieu}', [LieuController::class, 'update'])->name('lieux.update');
    Route::delete('lieux/{lieu}', [LieuController::class, 'destroy'])->name('lieux.destroy');
    Route::get('gares-lieux', [LieuController::class, 'getLieux'])->name('gares.getLieux');
    
    // Destinations Nationales
    Route::get('destinations_national', [DestinationNationalController::class, 'index'])->name('destinations_national.index');
    Route::get('destinations_national_create', [DestinationNationalController::class, 'create'])->name('destinations_national.create');
    Route::post('destinations_national', [DestinationNationalController::class, 'store'])->name('destinations_national.store');
    Route::get('destinations_national/{destinationsNational}', [DestinationNationalController::class, 'show'])->name('destinations_national.show');
    Route::get('destinations_national_edit/{destinationsNational}', [DestinationNationalController::class, 'edit'])->name('destinations_national.edit');
    Route::put('destinations_national/{destinationsNational}', [DestinationNationalController::class, 'update'])->name('destinations_national.update');
    Route::delete('destinations_national/{destinationsNational}', [DestinationNationalController::class, 'destroy'])->name('destinations_national.destroy');
    
    // Destinations Sous-Régionales
    Route::get('destinations_sousregion', [DestinationSousRegionController::class, 'index'])->name('destinations_sousregion.index');
    Route::get('destinations_sousregionc_reate', [DestinationSousRegionController::class, 'create'])->name('destinations_sousregion.create');
    Route::post('destinations_sousregion', [DestinationSousRegionController::class, 'store'])->name('destinations_sousregion.store');
    Route::get('destinations_sousregion/{destinationsSousregion}', [DestinationSousRegionController::class, 'show'])->name('destinations_sousregion.show');
    Route::get('destinations_sousregion_edit/{destinationsSousregion}', [DestinationSousRegionController::class, 'edit'])->name('destinations_sousregion.edit');
    Route::put('destinations_sousregion/{destinationsSousregion}', [DestinationSousRegionController::class, 'update'])->name('destinations_sousregion.update');
    Route::delete('destinations_sousregion/{destinationsSousregion}', [DestinationSousRegionController::class, 'destroy'])->name('destinations_sousregion.destroy');
    
    // Réservations
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations_create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('reservations_edit/{reservation}', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::patch('reservations_confirmer/{reservation}/', [ReservationController::class, 'confirmer'])->name('reservations.confirmer');
    Route::patch('reservations_annuler/{reservation}', [ReservationController::class, 'annuler'])->name('reservations.annuler');
    
    // Paiements
    Route::get('paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('paiements_create', [PaiementController::class, 'create'])->name('paiements.create');
    Route::post('paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('paiements/{paiement}', [PaiementController::class, 'show'])->name('paiements.show');
    Route::get('paiements_edit/{paiement}', [PaiementController::class, 'edit'])->name('paiements.edit');
    Route::put('paiements/{paiement}', [PaiementController::class, 'update'])->name('paiements.update');
    Route::delete('paiements/{paiement}', [PaiementController::class, 'destroy'])->name('paiements.destroy');
    
    // Utilisateurs
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users_create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users_edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Sous-traitants
    Route::get('soustraitants', [SousTraitantController::class, 'index'])->name('soustraitants.index');
    Route::get('soustraitants/create', [SousTraitantController::class, 'create'])->name('soustraitants.create');
    Route::post('soustraitants', [SousTraitantController::class, 'store'])->name('soustraitants.store');
    Route::get('soustraitants/{soustraitant}', [SousTraitantController::class, 'show'])->name('soustraitants.show');
    Route::get('soustraitants/{soustraitant}/edit', [SousTraitantController::class, 'edit'])->name('soustraitants.edit');
    Route::put('soustraitants/{soustraitant}', [SousTraitantController::class, 'update'])->name('soustraitants.update');
    Route::delete('soustraitants/{soustraitant}', [SousTraitantController::class, 'destroy'])->name('soustraitants.destroy');
    
    // Lignes Sous-traitants
    Route::get('lignes_soustraitants', [LigneSousTraitantController::class, 'index'])->name('lignes_soustraitants.index');
    Route::get('lignes_soustraitants/create', [LigneSousTraitantController::class, 'create'])->name('lignes_soustraitants.create');
    Route::post('lignes_soustraitants', [LigneSousTraitantController::class, 'store'])->name('lignes_soustraitants.store');
    Route::get('lignes_soustraitants/{lignes_soustraitant}', [LigneSousTraitantController::class, 'show'])->name('lignes_soustraitants.show');
    Route::get('lignes_soustraitants/{lignes_soustraitant}/edit', [LigneSousTraitantController::class, 'edit'])->name('lignes_soustraitants.edit');
    Route::put('lignes_soustraitants/{lignes_soustraitant}', [LigneSousTraitantController::class, 'update'])->name('lignes_soustraitants.update');
    Route::delete('lignes_soustraitants/{lignes_soustraitant}', [LigneSousTraitantController::class, 'destroy'])->name('lignes_soustraitants.destroy');
    Route::get('lignes-soustraitants/destinations', [LigneSousTraitantController::class, 'getDestinations'])->name('lignes_soustraitants.getDestinations');
});

/*
|--------------------------------------------------------------------------
| API Routes pour AJAX
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('societes/{societe}/gares', [SocieteController::class, 'getGares'])->name('api.societes.gares');
    Route::get('gares-lieux', [LieuController::class, 'getLieux'])->name('api.gares.lieux');
 
    Route::get('destinations/{type}/{societe}', [LigneSousTraitantController::class, 'getDestinations'])->name('api.destinations');
});


   Route::get('api/lieux-depart-national', [LieuController::class, 'getLieuxDepartNational'])->name('api.lieux.depart.national');
    Route::get('api/lieux-arrive-national', [LieuController::class, 'getLieuxArriveNational'])->name('api.lieux.arrive.national');
    Route::get('api/lieux-depart-sousregion', [LieuController::class, 'getLieuxDepartSousRegion'])->name('api.lieux.depart.sousregion');
    Route::get('api/lieux-arrive-sousregion', [LieuController::class, 'getLieuxArriveSousRegion'])->name('api.lieux.arrive.sousregion');
    Route::get('api/lieux-by-type/{typeDestination}', [LieuController::class, 'getLieuxByTypeDestination'])->name('api.lieux.by.type');
    Route::get('api/lieux/villes-par-pays/{pays}', [LieuController::class, 'getVillesParPays'])->name('api.lieux.villes.par.pays');
    Route::get('api/lieux/details', [LieuController::class, 'getLieuDetails'])->name('api.lieux.details');