<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DistributionController;
use App\Http\Controllers\Dashboard\DetailController;
use App\Http\Controllers\Dashboard\FilterController;
use App\Http\Controllers\Dashboard\BusinessController;
use App\Http\Controllers\Dashboard\OrganizationController;
use Laravel\Fortify\Features;

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/cooperatives', [FilterController::class, 'index'])->name('cooperatives.index');
    

    Route::get('/cooperatives/{id}', [DetailController::class,'index'])->name('cooperatives.show');

    Route::get('/distribution', [DistributionController::class, 'index'])->name('distribution.index');

    Route::get('/business', [BusinessController::class, 'index'])->name('business.index');

    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization.index');

// require __DIR__.'/settings.php';

//Route::get('/', [DashboardController::class, 'render'])->name('dashboard');
//Route::get('/cooperative/{id}', [DetailController::class, 'render'])->name('dashboard.detail');
//Route::get('/search', [SearchController::class, 'render'])->name('dashboard.search');
// Route::get('/business', [BusinessController::class, 'render'])->name('dashboard.business');
// Route::get('/organization', [OrganizationController::class, 'render'])->name('dashboard.organization');
