<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VoyageurAuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\LieuController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/register', [VoyageurAuthController::class, 'register']);
    Route::post('/login', [VoyageurAuthController::class, 'login']);
    
    // Public destination data
    Route::get('/destinations/national', [DestinationController::class, 'nationalDestinations']);
    Route::get('/destinations/regional', [DestinationController::class, 'regionalDestinations']);
    Route::get('/destinations/search', [DestinationController::class, 'search']);
    Route::get('/companies', [DestinationController::class, 'companies']);
    Route::get('/companies/{id}', [DestinationController::class, 'companyDetails']);
    Route::get('/locations', [DestinationController::class, 'locations']);
    
    // Lieux API routes
    Route::get('/lieux/villes-par-pays/{pays}', [LieuController::class, 'getVillesParPays']);
    Route::get('/lieux/details', [LieuController::class, 'getLieuDetails']);
});

// Protected routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [VoyageurAuthController::class, 'logout']);
    Route::get('/profile', [VoyageurAuthController::class, 'profile']);
    Route::put('/profile', [VoyageurAuthController::class, 'updateProfile']);
    Route::post('/change-password', [VoyageurAuthController::class, 'changePassword']);
    
    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::put('/reservationsupdate/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'cancel']);
    Route::get('/reservations/{id}/payments', [PaiementController::class, 'getPaymentsByReservation']);

    // Payment routes
    Route::get('/payments', [PaiementController::class, 'index']);
    Route::post('/payments', [PaiementController::class, 'store']);
    Route::get('/payments/{id}', [PaiementController::class, 'show']);
});