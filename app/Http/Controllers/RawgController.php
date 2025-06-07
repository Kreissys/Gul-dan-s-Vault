<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class RawgController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAWG_API_KEY');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return view('rawg-search');
        }

        $response = Http::get('https://api.rawg.io/api/games', [
            'key' => $this->apiKey,
            'search' => $query,
            'page_size' => 10,
        ]);

        if ($response->failed()) {
            return back()->withErrors('Error al obtener datos de la API de RAWG.');
        }

        $results = $response->json();

        // Verificar qué juegos ya están en la biblioteca del usuario
        if (Auth::check()) {
            $userGameIds = Game::where('user_id', Auth::id())
                ->pluck('rawg_id')
                ->toArray();

            // Agregar información de si el juego ya está en la biblioteca
            foreach ($results['results'] as &$game) {
                $game['in_library'] = in_array($game['id'], $userGameIds);
            }
        }

        return view('rawg-search', ['results' => $results, 'query' => $query]);
    }

    public function show($slug, Request $request)
    {
        $response = Http::get("https://api.rawg.io/api/games/{$slug}", [
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            abort(404, 'Juego no encontrado');
        }

        $game = $response->json();
        $query = $request->query('q');

        // Verificar si el usuario ya tiene este juego en su biblioteca
        $inLibrary = false;
        $userGame = null;

        if (Auth::check()) {
            $userGame = Game::where('user_id', Auth::id())
                ->where('rawg_id', $game['id'])
                ->first();
            
            $inLibrary = $userGame !== null;
        }

        return view('rawg-detail', [
            'game' => $game, 
            'query' => $query,
            'inLibrary' => $inLibrary,
            'userGame' => $userGame
        ]);
    }
}