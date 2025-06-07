<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class TestMongoController extends Controller
{
    public function index()
    {
        // Crear un registro de prueba
        $game = Game::create([
            'title' => 'The Witcher 3',
            'platform' => 'PC',
            'hours_played' => 150,
        ]);

        // Obtener todos los juegos
        $games = Game::all();

        return response()->json([
            'message' => 'MongoDB connection test successful!',
            'game_created' => $game,
            'all_games' => $games,
        ]);
    }
}
