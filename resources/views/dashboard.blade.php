@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 slide-in">
        <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">¡Bienvenido, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-400">Gestiona tu biblioteca personal de videojuegos</p>
    </div>

    {{-- Juegos recomendados --}}
    @php
        $recommendations = (new \App\Http\Controllers\GameRecommendationController())->getRecommendations(Auth::user());
    @endphp

    <div class="card-glass p-6 slide-in mb-8">
        <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center">
            <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
            Juegos recomendados
        </h3>
        
        @if(empty($recommendations))
            <p class="text-slate-400 text-center">No se encontraron juegos recomendados en este momento</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recommendations as $game)
                    <div class="card-glass overflow-hidden hover:scale-105 transition-all duration-300 group slide-in">
                        <a href="{{ route('rawg.show', ['slug' => $game['slug']]) }}" class="block">
                            <div class="relative overflow-hidden">
                                @if($game['background_image'])
                                    <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}" 
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center group-hover:from-slate-500 group-hover:to-slate-600 transition-colors duration-300">
                                        <span class="text-slate-400">Sin imagen</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-4">
                            <a href="{{ route('rawg.show', ['slug' => $game['slug']]) }}" class="block">
                                <h4 class="text-lg font-medium text-slate-100 mb-2 hover:text-green-400 transition-colors">{{ $game['name'] }}</h4>
                            </a>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        @foreach($game['genres'] as $genre)
                                            <span class="text-sm text-slate-400">{{ $genre }}</span>
                                        @endforeach
                                    </div>
                                    @if($game['metacritic'])
                                        <span class="ml-2 px-2 py-1 text-xs bg-orange-500/20 text-orange-400 rounded-full">
                                            {{ $game['metacritic'] }}
                                        </span>
                                    @endif
                                    @if($game['rating'])
                                        <span class="ml-2 px-2 py-1 text-xs bg-blue-500/20 text-blue-400 rounded-full">
                                            {{ number_format($game['rating'], 1) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    @if($game['released'])
                                        <span class="text-sm text-slate-400">{{ \Carbon\Carbon::parse($game['released'])->format('Y') }}</span>
                                    @endif
                                    <form action="{{ route('games.store') }}" method="POST" class="inline ml-2">
                                        @csrf
                                        <input type="hidden" name="rawg_id" value="{{ $game['id'] }}">
                                        <input type="hidden" name="rawg_slug" value="{{ $game['slug'] }}">
                                        <input type="hidden" name="status" value="pendiente">
                                        <button type="submit" 
                                                class="p-2 rounded-lg hover:bg-slate-700 transition-colors"
                                                title="Agregar a mi biblioteca">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Estadísticas rápidas --}}
    @php
        $totalGames = App\Models\Game::where('user_id', Auth::id())->count();
        $playingGames = App\Models\Game::where('user_id', Auth::id())->where('status', 'jugando')->count();
        $completedGames = App\Models\Game::where('user_id', Auth::id())->where('status', 'completado')->count();
        $totalHoursRaw = App\Models\Game::where('user_id', Auth::id())->sum('hours_played');
        $totalHours = $totalHoursRaw instanceof \MongoDB\BSON\Decimal128 ? (float) $totalHoursRaw->__toString() : (float) $totalHoursRaw;
        $recentGames = App\Models\Game::where('user_id', Auth::id())->orderBy('created_at', 'desc')->limit(6)->get();
    @endphp

    {{-- Tarjetas de estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card-glass p-6 slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center">
                        <span class="text-xl">📚</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-400">Total de juegos</p>
                    <p class="text-2xl font-bold text-slate-100">{{ $totalGames }}</p>
                </div>
            </div>
        </div>

        <div class="card-glass p-6 slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-xl">🎮</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-400">Jugando ahora</p>
                    <p class="text-2xl font-bold text-blue-400">{{ $playingGames }}</p>
                </div>
            </div>
        </div>

        <div class="card-glass p-6 slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-400">Completados</p>
                    <p class="text-2xl font-bold text-green-400">{{ $completedGames }}</p>
                </div>
            </div>
        </div>

        <div class="card-glass p-6 slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-xl">⏱️</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-400">Horas totales</p>
                    <p class="text-2xl font-bold text-purple-400">{{ number_format($totalHours, 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="card-glass p-6 slide-in">
            <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                Acciones rápidas
            </h3>
            <div class="space-y-3">
                <a href="{{ route('rawg.search') }}" class="flex items-center p-4 bg-slate-700/50 rounded-lg hover:bg-slate-600/50 transition-all duration-300 group border border-slate-600 hover:border-green-400">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-lg">🔍</span>
                    </div>
                    <div>
                        <p class="font-medium text-slate-100 group-hover:text-green-400 transition-colors">Buscar juegos</p>
                        <p class="text-sm text-slate-400">Encuentra nuevos juegos para agregar</p>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}" class="flex items-center p-4 bg-slate-700/50 rounded-lg hover:bg-slate-600/50 transition-all duration-300 group border border-slate-600 hover:border-green-400">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-lg">📚</span>
                    </div>
                    <div>
                        <p class="font-medium text-slate-100 group-hover:text-green-400 transition-colors">Ver mi biblioteca</p>
                        <p class="text-sm text-slate-400">Gestiona tu colección completa</p>
                    </div>
                </a>
                
                @if($playingGames > 0)
                    <a href="{{ route('games.filter', ['status' => 'jugando']) }}" class="flex items-center p-4 bg-slate-700/50 rounded-lg hover:bg-slate-600/50 transition-all duration-300 group border border-slate-600 hover:border-green-400">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <span class="text-lg">🎮</span>
                        </div>
                        <div>
                            <p class="font-medium text-slate-100 group-hover:text-green-400 transition-colors">Juegos en progreso</p>
                            <p class="text-sm text-slate-400">Continúa donde lo dejaste</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        <div class="card-glass p-6 slide-in">
            <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center">
                <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                Progreso de biblioteca
            </h3>
            @if($totalGames > 0)
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-300">Completados</span>
                            <span class="text-slate-400">{{ $completedGames }}/{{ $totalGames }}</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $totalGames > 0 ? ($completedGames / $totalGames) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">{{ $totalGames > 0 ? round(($completedGames / $totalGames) * 100, 1) : 0 }}% completado</p>
                    </div>
                    
                    @if($playingGames > 0)
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-300">En progreso</span>
                                <span class="text-slate-400">{{ $playingGames }}/{{ $totalGames }}</span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-3 rounded-full transition-all duration-1000 ease-out" 
                                     style="width: {{ ($playingGames / $totalGames) * 100 }}%"></div>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">{{ round(($playingGames / $totalGames) * 100, 1) }}% en progreso</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎮</span>
                    </div>
                    <p class="text-slate-400 mb-4">Aún no tienes juegos en tu biblioteca</p>
                    <a href="{{ route('rawg.search') }}" class="btn-primary text-white px-6 py-3 rounded-lg font-medium inline-flex items-center space-x-2">
                        <span>🔍</span>
                        <span>Agregar tu primer juego</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Juegos recientes --}}
    @if($recentGames->count() > 0)
        <div class="card-glass p-6 slide-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-100 flex items-center">
                    <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
                    Agregados recientemente
                </h3>
                <a href="{{ route('games.index') }}" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver todos →
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($recentGames as $game)
                    <div class="group cursor-pointer">
                        <a href="{{ route('games.show', $game) }}" class="block">
                            <div class="relative overflow-hidden rounded-lg mb-3">
                                @if($game->image)
                                    <img src="{{ $game->image }}" alt="{{ $game->title }}" 
                                         class="w-full h-24 sm:h-32 object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @else
                                    <div class="w-full h-24 sm:h-32 bg-gradient-to-br from-slate-600 to-slate-700 rounded-lg flex items-center justify-center group-hover:from-slate-500 group-hover:to-slate-600 transition-colors duration-300">
                                        <span class="text-slate-400 text-xs">Sin imagen</span>
                                    </div>
                                @endif
                                
                                {{-- Status badge --}}
                                <div class="absolute top-2 right-2">
                                    <span class="status-badge px-2 py-1 text-xs font-medium rounded-full {{ $game->status_color }} text-white">
                                        {{ $game->status_text }}
                                    </span>
                                </div>
                            </div>
                            
                            <h4 class="font-medium text-sm text-slate-100 truncate group-hover:text-green-400 transition-colors">
                                {{ $game->title }}
                            </h4>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $game->release_date ? $game->release_date->format('Y') : 'N/A' }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection