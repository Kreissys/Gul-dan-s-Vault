<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Collection;

class GameRecommendationController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAWG_API_KEY');
    }

    /**
     * Obtener juegos recomendados aleatorios
     */
    public function getRecommendations(User $user)
    {
        try {
            // Obtener juegos populares y bien calificados
            $response = Http::get('https://api.rawg.io/api/games', [
                'key' => $this->apiKey,
                'page_size' => 120, // Obtenemos más para poder seleccionar aleatoriamente
                'metacritic' => '20,100', // Solo juegos con buena calificación
            ]);

            if ($response->successful()) {
                $games = $response->json()['results'] ?? [];
                
                // Si hay suficientes juegos, seleccionamos 6 aleatoriamente
                if (count($games) >= 6) {
                    $games = collect($games)->random(6);
                } else {
                    $games = collect($games);
                }

                return $games->map(function($game) {
                    // Obtener los géneros del juego (máximo 2)
                    $genres = collect($game['genres'] ?? [])->map(function($genre) {
                        return $genre['name'] ?? 'Sin género';
                    })->take(2)->toArray();

                    return [
                        'id' => $game['id'],
                        'name' => $game['name'],
                        'slug' => $game['slug'],
                        'background_image' => $game['background_image'],
                        'genres' => $genres,
                        'metacritic' => $game['metacritic'] ?? null,
                        'playtime' => $game['playtime'] ?? 0,
                        'rating' => $game['rating'] ?? null,
                        'released' => $game['released'] ?? null
                    ];
                })->toArray();
            }
            
            return [];
        } catch (\Exception $e) {
            \Log::error('Error al obtener recomendaciones de juegos: ' . $e->getMessage());
            return [];
        }
    }
}
