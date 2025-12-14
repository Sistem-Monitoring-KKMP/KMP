<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManajemenKMP\AuthController;
use App\Http\Controllers\ManajemenKMP\UserController;
use App\Http\Controllers\ManajemenKMP\AnggotaController;
use App\Http\Controllers\ManajemenKMP\KoperasiController;
use App\Http\Controllers\ManajemenKMP\LokasiKoperasiController;
use App\Http\Controllers\ManajemenKMP\KecamatanController;
use App\Http\Controllers\ManajemenKMP\KelurahanController;
use App\Http\Controllers\ManajemenKMP\PengurusController;
use App\Http\Controllers\ManajemenKMP\RespondenController;
use App\Http\Controllers\ManajemenKMP\PerformaController;
use App\Http\Controllers\ManajemenKMP\PerformaBisnisController;
use App\Http\Controllers\ManajemenKMP\PerformaOrganisasiController;


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
        Route::get('/anggota-user/{anggotaId}', [UserController::class, 'getByAnggotaId']);
        Route::post('/{id}/change-password', [UserController::class, 'changePassword']);
    });

    // Anggota management routes
    Route::prefix('users/anggota')->group(function () {
        Route::get('/', [AnggotaController::class, 'index']);
        Route::get('/{id}', [AnggotaController::class, 'show']);
        Route::post('/', [AnggotaController::class, 'store']);
        Route::put('/{id}', [AnggotaController::class, 'update']);
        Route::post('/{id}', [AnggotaController::class, 'update']);
        Route::delete('/{id}', [AnggotaController::class, 'destroy']);
    });

    // Koperasi management routes
    Route::prefix('koperasi')->group(function () {
        Route::get('/', [KoperasiController::class, 'index']);
        Route::get('/{id}', [KoperasiController::class, 'show']);
        Route::post('/', [KoperasiController::class, 'store']);
        Route::put('/{id}', [KoperasiController::class, 'update']);
        Route::delete('/{id}', [KoperasiController::class, 'destroy']);

        // Lokasi Koperasi routes
        Route::prefix('{koperasiId}/lokasi')->group(function () {
            Route::get('/', [LokasiKoperasiController::class, 'getByKoperasiId']);
            Route::post('/', [LokasiKoperasiController::class, 'saveLokasiKoperasi']);
        });

        // Pengurus routes
        Route::prefix('{koperasiId}/pengurus')->group(function () {
            Route::get('/', [PengurusController::class, 'getByKoperasiId']);
            Route::post('/', [PengurusController::class, 'store']);
            Route::put('/{id}', [PengurusController::class, 'update']);
            Route::delete('/{id}', [PengurusController::class, 'destroy']);
        });

        // Responden routes
        Route::prefix('{koperasiId}/responden')->group(function () {
            Route::get('/', [RespondenController::class, 'getByKoperasiId']);
            Route::post('/', [RespondenController::class, 'saveResponden']);
            Route::delete('/', [RespondenController::class, 'destroy']);
        });

        // ✅ Performa routes
        Route::prefix('{koperasiId}/performa')->group(function () {
            Route::get('/periods', [PerformaController::class, 'getPeriods']);
            Route::get('/{period}', [PerformaController::class, 'getByPeriod']);
            Route::post('/', [PerformaController::class, 'savePerforma']);
            Route::delete('/{performaId}', [PerformaController::class, 'destroy']);

            Route::prefix('{performaId}/bisnis')->group(function () {
                Route::get('/', [PerformaBisnisController::class, 'show']);
                Route::put('/', [PerformaBisnisController::class, 'save']);
            });

            Route::prefix('{performaId}/organisasi')->group(function () {
                Route::get('/', [PerformaOrganisasiController::class, 'show']);
                Route::put('/', [PerformaOrganisasiController::class, 'save']);
            });
        });
    });

    // Kecamatan routes
    Route::get('/kecamatan', [KecamatanController::class, 'getAllKecamatan']);

    // Kelurahan routes
    Route::get('/kelurahan', [KelurahanController::class, 'getAllKelurahan']);
});
