@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Bienvenido, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600">Gestiona tu biblioteca personal de videojuegos</p>
    </div>

    {{-- Estadísticas rápidas --}}
    @php
        $totalGames = App\Models\Game::where('user_id', Auth::id())->count();
        $playingGames = App\Models\Game::where('user_id', Auth::id())->where('status', 'jugando')->count();
        $completedGames = App\Models\Game::where('user_id', Auth::id())->where('status', 'completado')->count();
        $totalHours = App\Models\Game::where('user_id', Auth::id())->sum('hours_played');
        $recentGames = App\Models\Game::where('user_id', Auth::id())->orderBy('created_at', 'desc')->limit(6)->get();
    @endphp

    {{-- Tarjetas de estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">📚</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de juegos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalGames }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">🎮</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Jugando ahora</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $playingGames }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-bold">✅</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Completados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $completedGames }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-purple-600 font-bold">⏱️</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Horas totales</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalHours }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Acciones rápidas</h3>
            <div class="space-y-3">
                <a href="{{ route('rawg.search') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="text-blue-600 mr-3">🔍</span>
                    <div>
                        <p class="font-medium text-gray-900">Buscar juegos</p>
                        <p class="text-sm text-gray-600">Encuentra nuevos juegos para agregar</p>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="text-green-600 mr-3">📚</span>
                    <div>
                        <p class="font-medium text-gray-900">Ver mi biblioteca</p>
                        <p class="text-sm text-gray-600">Gestiona tu colección completa</p>
                    </div>
                </a>
                
                @if($playingGames > 0)
                    <a href="{{ route('games.filter', ['status' => 'jugando']) }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <span class="text-purple-600 mr-3">🎮</span>
                        <div>
                            <p class="font-medium text-gray-900">Juegos en progreso</p>
                            <p class="text-sm text-gray-600">Continúa donde lo dejaste</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Progreso de biblioteca</h3>
            @if($totalGames > 0)
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Completados</span>
                            <span>{{ $completedGames }}/{{ $totalGames }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalGames > 0 ? ($completedGames / $totalGames) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    @if($playingGames > 0)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>En progreso</span>
                                <span>{{ $playingGames }}/{{ $totalGames }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($playingGames / $totalGames) * 100 }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Aún no tienes juegos en tu biblioteca</p>
                    <a href="{{ route('rawg.search') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Agregar tu primer juego
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Juegos recientes --}}
    @if($recentGames->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Agregados recientemente</h3>
                <a href="{{ route('games.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Ver todos</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($recentGames as $game)
                    <div class="group cursor-pointer">
                        <a href="{{ route('games.show', $game) }}">
                            @if($game->image)
                                <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-32 object-cover rounded-lg mb-2 group-hover:opacity-75 transition-opacity">
                            @else
                                <div class="w-full h-32 bg-gray-200 rounded-lg mb-2 flex items-center justify-center group-hover:bg-gray-300 transition-colors">
                                    <span class="text-gray-500 text-xs">Sin imagen</span>
                                </div>
                            @endif
                            <h4 class="font-medium text-sm truncate group-hover:text-blue-600">{{ $game->title }}</h4>
                            <p class="text-xs text-gray-500">{{ $game->status_text }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection