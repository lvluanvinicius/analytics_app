<?php

use App\Http\Controllers\Application\EquipamentController;
use App\Http\Controllers\Application\OnuInventoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->prefix('app')->as('app.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('onu-nventory', [OnuInventoryController::class, 'index'])->name('onu-nventory');
    Route::get('onu-nventory/json', [OnuInventoryController::class, 'inventoryData'])->name('inventory-data');

    Route::get('equipament/{equipament}/ports', [EquipamentController::class, 'ports'])->name('equipament-ports');
    Route::resource('equipaments', EquipamentController::class);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
