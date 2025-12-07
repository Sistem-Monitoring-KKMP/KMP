<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

    Route::get('/', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('/cooperatives', function () {
        return Inertia::render('cooperatives/index');
    })->name('cooperatives.index');

    Route::get('/cooperatives/{id}', function ($id) {
        return Inertia::render('cooperatives/show', [
            'id' => $id
        ]);
    })->name('cooperatives.show');

    Route::get('/business', function () {
        return Inertia::render('business/index');
    })->name('business.index');

// require __DIR__.'/settings.php';
