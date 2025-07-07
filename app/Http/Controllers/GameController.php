<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAWG_API_KEY');
    }

    /**
     * Mostrar la biblioteca del usuario
     */
    public function index()
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        $games = Game::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $games->count(),
            'playing' => $games->where('status', 'jugando')->count(),
            'completed' => $games->where('status', 'completado')->count(),
            'pending' => $games->where('status', 'pendiente')->count(),
            'dropped' => $games->where('status', 'abandonado')->count(),
            'total_hours' => $games->sum('hours_played')
        ];

        return view('games.index', compact('games', 'stats'));
    }

    /**
     * Agregar juego desde RAWG a la biblioteca
     */
    public function store(Request $request)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        $request->validate([
            'rawg_id' => 'required|integer',
            'rawg_slug' => 'required|string',
            'status' => 'required|in:pendiente,jugando,completado,abandonado',
            'rating' => 'nullable|integer|min:1|max:10',
        ]);

        // Verificar si el usuario ya tiene este juego
        $existingGame = Game::where('user_id', Auth::id())
            ->where('rawg_id', $request->rawg_id)
            ->first();

        if ($existingGame) {
            return back()->with('error', 'Ya tienes este juego en tu biblioteca.');
        }

        // Obtener datos del juego desde RAWG API
        $response = Http::get("https://api.rawg.io/api/games/{$request->rawg_slug}", [
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Error al obtener los datos del juego.');
        }

        $gameData = $response->json();

        // Crear el juego en la biblioteca del usuario
        Game::create([
            'user_id' => Auth::id(),
            'rawg_id' => $request->rawg_id,
            'rawg_slug' => $request->rawg_slug,
            'title' => $gameData['name'],
            'image' => $gameData['background_image'] ?? null,
            'release_date' => $gameData['released'] ?? null,
            'genres' => collect($gameData['genres'] ?? [])->pluck('name')->toArray(),
            'platforms' => collect($gameData['platforms'] ?? [])->pluck('platform.name')->toArray(),
            'status' => $request->status,
            'rating' => $request->rating,
            'hours_played' => 0,
            'metacritic_score' => $gameData['metacritic'] ?? null,
            'playtime' => $gameData['playtime'] ?? 0,
        ]);

        return back()->with('success', 'Juego agregado a tu biblioteca exitosamente.');
    }

    /**
     * Mostrar detalles de un juego de la biblioteca
     */
    public function show(Game $game)
    {
        // Verificar que el juego pertenece al usuario autenticado
        if ($game->user_id !== Auth::id()) {
            abort(403);
        }

        return view('games.show', compact('game'));
    }

    /**
     * Actualizar información del juego en la biblioteca
     */
    public function update(Request $request, Game $game)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        // Verificar que el juego pertenece al usuario autenticado
        if ($game->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pendiente,jugando,completado,abandonado',
            'rating' => 'nullable|integer|min:1|max:10',
            'hours_played' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $game->update([
            'status' => $request->status,
            'rating' => $request->rating,
            'hours_played' => $request->hours_played ?? 0,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Juego actualizado exitosamente.');
    }

    /**
     * Eliminar juego de la biblioteca
     */
    public function destroy(Game $game)
    {
        // Verificar si el usuario está desactivado
        if (Auth::check() && !Auth::user()->is_active) {
            return view('blocked');
        }

        // Verificar que el juego pertenece al usuario autenticado
        if ($game->user_id !== Auth::id()) {
            abort(403);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Juego eliminado de tu biblioteca.');
    }

    /**
     * Filtrar juegos por estado
     */
    public function filter(Request $request)
    {
        $status = $request->get('status');
        $query = Game::where('user_id', Auth::id());

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $games = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => Game::where('user_id', Auth::id())->count(),
            'playing' => Game::where('user_id', Auth::id())->where('status', 'jugando')->count(),
            'completed' => Game::where('user_id', Auth::id())->where('status', 'completado')->count(),
            'pending' => Game::where('user_id', Auth::id())->where('status', 'pendiente')->count(),
            'dropped' => Game::where('user_id', Auth::id())->where('status', 'abandonado')->count(),
            'total_hours' => Game::where('user_id', Auth::id())->sum('hours_played')
        ];

        return view('games.index', compact('games', 'stats', 'status'));
    }
}