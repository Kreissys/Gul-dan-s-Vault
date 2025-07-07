<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class UserGameStatsController extends Controller
{
    public function show(User $user)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Obtener estadísticas del usuario
        $stats = [
            'total' => Game::where('user_id', $user->_id)->count(),
            'playing' => Game::where('user_id', $user->_id)->where('status', 'jugando')->count(),
            'completed' => Game::where('user_id', $user->_id)->where('status', 'completado')->count(),
            'pending' => Game::where('user_id', $user->_id)->where('status', 'pendiente')->count(),
            'dropped' => Game::where('user_id', $user->_id)->where('status', 'abandonado')->count(),
            'total_hours' => Game::where('user_id', $user->_id)->sum('hours_played'),
        ];

        // Obtener juegos del usuario
        $games = Game::where('user_id', $user->_id)->with(['user'])->get();

        return view('user-management.game-stats', compact('user', 'games', 'stats'));
    }
}
