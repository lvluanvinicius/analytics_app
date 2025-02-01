<?php

use App\Http\Controllers\Application\OnuInventoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('app')->as('app.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    });

    Route::get('onu-nventory', [OnuInventoryController::class, 'index'])->name('onu-nventory');
})->middleware(['auth', 'verified'])->name('dashboard');
