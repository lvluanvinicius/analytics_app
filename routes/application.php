<?php

use App\Http\Controllers\Application\OnuInventoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->prefix('app')->as('app.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('onu-nventory', [OnuInventoryController::class, 'index'])->name('onu-nventory');
});
