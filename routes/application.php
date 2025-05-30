<?php

use App\Http\Controllers\Application\EquipamentController;
use App\Http\Controllers\Application\OnuInventoryController;
use App\Http\Controllers\Application\OnuNamesController;
use App\Http\Controllers\Application\PortsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\Integration\Authenticated;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([Authenticated::class])->prefix('app')->as('app.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('onu-nventory', [OnuInventoryController::class, 'index'])->name('onu-nventory');
    Route::get('onu-nventory/json', [OnuInventoryController::class, 'inventoryData'])->name('inventory-data');

    Route::get('equipament/ports/json', [PortsController::class, 'ports'])->name('equipament-ports');
    Route::get('equipaments/json', [EquipamentController::class, 'indexJson'])->name('equipaments-json');

    Route::resource('equipaments', EquipamentController::class);

    Route::get('onu-names/json', [OnuNamesController::class, 'indexJson'])->name('onu-names');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
