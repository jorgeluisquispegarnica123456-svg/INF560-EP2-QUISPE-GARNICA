<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\Guia\PanelGuiaController;

// Rutas Públicas (Catálogo)
Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/tours/{tour:slug}', [CatalogoController::class, 'show'])->name('catalogo.show');

// Redirección inteligente tras iniciar sesión según el rol
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.tours.index');
    }
    if ($user->hasRole('Guía')) {
        return redirect()->route('guia.panel');
    }
    return redirect()->route('turista.reservas');
})->middleware(['auth'])->name('dashboard');

// Rutas del Turista (Autenticado)
Route::middleware(['auth', 'role:Turista|Admin'])->group(function () {
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('turista.reservas');
    Route::post('/tours/{tour}/reservar', [ReservaController::class, 'store'])->name('reservas.store');
    Route::patch('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
});

// Rutas del Guía
Route::middleware(['auth', 'role:Guía'])->prefix('guia')->name('guia.')->group(function () {
    Route::get('/panel', [PanelGuiaController::class, 'index'])->name('panel');
});

// Rutas del Administrador
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tours', TourController::class);
    Route::get('/reservas', [ReservaAdminController::class, 'index'])->name('reservas.index');
    Route::patch('/reservas/{reserva}/estado', [ReservaAdminController::class, 'cambiarEstado'])->name('reservas.estado');
});

// Perfil de usuario (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';