<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Game;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Obtener estadísticas del usuario
        $stats = $this->getUserStats($user->_id);
        
        // Obtener juegos recientes
        $recentGames = Game::where('user_id', $user->_id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
            
        // Obtener juegos favoritos (rating alto)
        $favoriteGames = Game::where('user_id', $user->_id)
            ->whereNotNull('rating')
            ->where('rating', '>=', 8)
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get();

        return view('profile.edit', compact('user', 'stats', 'recentGames', 'favoriteGames'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Eliminar todos los juegos del usuario
        Game::where('user_id', $user->_id)->delete();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Obtener estadísticas del usuario
     */
    private function getUserStats($userId)
    {
        $games = Game::where('user_id', $userId)->get();
        
        return [
            'total_games' => $games->count(),
            'completed_games' => $games->where('status', 'completado')->count(),
            'playing_games' => $games->where('status', 'jugando')->count(),
            'pending_games' => $games->where('status', 'pendiente')->count(),
            'dropped_games' => $games->where('status', 'abandonado')->count(),
            'total_hours' => $games->sum('hours_played'),
            'average_rating' => $games->whereNotNull('rating')->avg('rating'),
            'completion_rate' => $games->count() > 0 ? round(($games->where('status', 'completado')->count() / $games->count()) * 100, 1) : 0,
            'favorite_genres' => $this->getFavoriteGenres($games),
            'monthly_hours' => $this->getMonthlyHours($games),
        ];
    }

    /**
     * Obtener géneros favoritos
     */
    private function getFavoriteGenres($games)
    {
        $allGenres = [];
        
        foreach ($games as $game) {
            if (is_array($game->genres)) {
                foreach ($game->genres as $genre) {
                    $allGenres[] = $genre;
                }
            }
        }
        
        $genreCounts = array_count_values($allGenres);
        arsort($genreCounts);
        
        return array_slice($genreCounts, 0, 5, true);
    }

    /**
     * Obtener horas jugadas en el último mes (aproximado)
     */
    private function getMonthlyHours($games)
    {
        $recentGames = $games->where('updated_at', '>=', now()->subMonth());
        return $recentGames->sum('hours_played');
    }
}