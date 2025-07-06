<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestMongoController;
use App\Http\Controllers\RawgController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para búsqueda de juegos con RAWG API
Route::middleware('auth')->group(function () {
    Route::get('/rawg/search', [RawgController::class, 'search'])->name('rawg.search');
    Route::get('/rawg/game/{slug}', [RawgController::class, 'show'])->name('rawg.show');
});

// Rutas para la biblioteca personal de juegos
Route::middleware('auth')->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/filter', [GameController::class, 'filter'])->name('games.filter');
    Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
});

// Ruta para la gestión de usuarios (solo para administradores)
Route::middleware(['auth'])->group(function () {
    Route::get('/user-management', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('user-management.index');
    Route::get('/user-management/{user}/edit', [\App\Http\Controllers\UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::put('/user-management/{user}', [\App\Http\Controllers\UserManagementController::class, 'update'])->name('user-management.update');
    Route::delete('/user-management/{user}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])->name('user-management.destroy');
});

// Rutas para la foto de perfil
Route::middleware(['auth'])->group(function () {
    Route::post('/profile-photo', [\App\Http\Controllers\ProfilePhotoController::class, 'update'])->name('profile-photo.update');
    Route::delete('/profile-photo', [\App\Http\Controllers\ProfilePhotoController::class, 'destroy'])->name('profile-photo.destroy');
});

Route::get('/test-mongo', [TestMongoController::class, 'index']);

require __DIR__.'/auth.php';