<?php


use Illuminate\Support\Facades\Route;
use App\ManajemenKMP\Http\Controllers\AuthController;
use App\ManajemenKMP\Http\Controllers\UserController;
use App\ManajemenKMP\Http\Controllers\AnggotaController;
use App\ManajemenKMP\Http\Controllers\KoperasiController;

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('jwt.auth')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // User management routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);

        // Additional user routes
        Route::get('/anggota-user/{anggotaId}', [UserController::class, 'getByAnggotaId']);
        Route::post('/{id}/change-password', [UserController::class, 'changePassword']);
    });

    // Anggota management routes
    Route::prefix('users/anggota')->group(function () {
        Route::get('/', [AnggotaController::class, 'index']);
        Route::get('/{id}', [AnggotaController::class, 'show']);
        Route::post('/', [AnggotaController::class, 'store']);
        Route::put('/{id}', [AnggotaController::class, 'update']);
        Route::post('/{id}', [AnggotaController::class, 'update']); // Support form-data
        Route::delete('/{id}', [AnggotaController::class, 'destroy']);
    });

    // Koperasi management routes
    Route::prefix('koperasi')->group(function () {
        Route::get('/', [KoperasiController::class, 'index']);
        Route::get('/{id}', [KoperasiController::class, 'show']);
        Route::post('/', [KoperasiController::class, 'store']);
        Route::put('/{id}', [KoperasiController::class, 'update']);
        Route::delete('/{id}', [KoperasiController::class, 'destroy']);
    });
});