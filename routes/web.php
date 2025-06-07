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

Route::get('/test-mongo', [TestMongoController::class, 'index']);

require __DIR__.'/auth.php';