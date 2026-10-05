<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// Página pública para clientes
Route::get('/', [TrackingController::class, 'index'])
    ->middleware('throttle:30,1')
    ->name('tracking.index');

// Panel privado (requiere login)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/paquetes', [PackageController::class, 'index'])->name('packages.index');
    Route::post('/paquetes', [PackageController::class, 'store'])->name('packages.store');
});

// Breeze redirige aquí después de iniciar sesión
Route::get('/dashboard', fn () => redirect()->route('admin.packages.index'))
    ->middleware('auth')
    ->name('dashboard');

require __DIR__.'/auth.php';
