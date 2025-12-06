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

// require __DIR__.'/settings.php';
