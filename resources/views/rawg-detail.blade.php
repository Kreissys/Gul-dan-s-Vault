@extends('layouts.app')

@section('title', $game['name'] . ' - Detalle del Juego')

@section('content')
<div class="slide-in">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('rawg.search', ['q' => $query]) }}" 
           class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a resultados
        </a>
    </div>

    {{-- Main Game Card --}}
    <div class="card-glass p-8 mb-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Game Image --}}
            <div class="flex-shrink-0">
                @if(!empty($game['background_image']))
                    <img src="{{ $game['background_image'] }}" 
                         alt="Imagen de {{ $game['name'] }}" 
                         class="w-full lg:w-80 h-64 lg:h-auto object-cover rounded-lg shadow-lg">
                @else
                    <div class="w-full lg:w-80 h-64 bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg shadow-lg flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Game Info --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-4xl font-bold brand-font bg-gradient-to-r from-green-400 to-purple-400 bg-clip-text text-transparent mb-6">
                    {{ $game['name'] }}
                </h1>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-600">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs text-slate-400 font-medium">Lanzamiento</span>
                        </div>
                        <p class="text-slate-100 font-semibold">{{ $game['released'] ?? 'Desconocido' }}</p>
                    </div>

                    <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-600">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs text-slate-400 font-medium">Duración</span>
                        </div>
                        <p class="text-slate-100 font-semibold">{{ $game['playtime'] ?? 'N/A' }} horas</p>
                    </div>

                    @if($game['metacritic'])
                    <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-600">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-4 h-4 bg-yellow-500 text-black text-xs font-bold rounded flex items-center justify-center">M</span>
                            <span class="text-xs text-slate-400 font-medium">Metacritic</span>
                        </div>
                        <p class="text-slate-100 font-semibold">{{ $game['metacritic'] }}</p>
                    </div>
                    @endif

                    <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-600">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-xs text-slate-400 font-medium">Jugadores</span>
                        </div>
                        <p class="text-slate-100 font-semibold">{{ number_format($game['added'] ?? 0) }}</p>
                    </div>
                </div>

                {{-- Genres --}}
                @if(!empty($game['genres']))
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-slate-300 mb-3 flex items-center">
                            <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                            Géneros
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($game['genres'] as $genre)
                                <span class="px-3 py-1 bg-gradient-to-r from-purple-500/20 to-green-500/20 text-slate-300 text-sm rounded-full border border-purple-500/30">
                                    {{ $genre['name'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Platforms --}}
                @if(!empty($game['platforms']))
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-slate-300 mb-3 flex items-center">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                            Plataformas
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($game['platforms'], 0, 6) as $platform)
                                <span class="px-3 py-1 bg-slate-700 text-slate-300 text-sm rounded-md border border-slate-600">
                                    {{ $platform['platform']['name'] }}
                                </span>
                            @endforeach
                            @if(count($game['platforms']) > 6)
                                <span class="px-3 py-1 bg-slate-600 text-slate-400 text-sm rounded-md">
                                    +{{ count($game['platforms']) - 6 }} más
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Developers --}}
                @if(!empty($game['developers']))
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-slate-300 mb-2 flex items-center">
                            <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
                            Desarrolladores
                        </h3>
                        <p class="text-slate-400">{{ implode(', ', array_map(fn($d) => $d['name'], $game['developers'])) }}</p>
                    </div>
                @endif

                {{-- Official Website --}}
                @if(!empty($game['website']))
                    <div class="mb-6">
                        <a href="{{ $game['website'] }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Sitio oficial
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Library Actions --}}
    @auth
        <div class="card-glass p-6 mb-8">
            @if($inLibrary)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-green-400 mb-1">¡Ya está en tu biblioteca!</h3>
                            <p class="text-slate-400">Estado: <span class="text-slate-300">{{ $userGame->status_text }}</span></p>
                            @if($userGame->rating)
                                <p class="text-slate-400">Tu puntuación: <span class="text-yellow-400 font-semibold">{{ $userGame->rating }}/10</span></p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('games.show', $userGame) }}" 
                       class="btn-primary px-6 py-3 rounded-lg font-medium inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver en biblioteca
                    </a>
                </div>
            @else
                <div>
                    <h3 class="text-xl font-bold text-slate-100 mb-6 flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                        Agregar a mi biblioteca
                    </h3>
                    <form method="POST" action="{{ route('games.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="rawg_id" value="{{ $game['id'] }}">
                        <input type="hidden" name="rawg_slug" value="{{ $game['slug'] }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-3">Estado del juego</label>
                                <select name="status" required class="w-full bg-slate-800 border border-slate-600 rounded-lg text-slate-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                    <option value="">Seleccionar estado</option>
                                    <option value="pendiente">📚 Pendiente</option>
                                    <option value="jugando">🎮 Jugando</option>
                                    <option value="completado">✅ Completado</option>
                                    <option value="abandonado">⏹️ Abandonado</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-3">Puntuación (opcional)</label>
                                <select name="rating" class="w-full bg-slate-800 border border-slate-600 rounded-lg text-slate-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                    <option value="">Sin puntuación</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">⭐ {{ $i }}/10</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full btn-primary py-4 rounded-lg font-medium text-lg flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar a mi biblioteca
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @else
        <div class="card-glass p-8 text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500/20 to-purple-600/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-100 mb-3">Inicia sesión para agregar juegos</h3>
            <p class="text-slate-400 mb-6">Crea tu biblioteca personal y gestiona tu colección de videojuegos</p>
            <a href="{{ route('login') }}" class="btn-primary px-6 py-3 rounded-lg font-medium inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Iniciar sesión
            </a>
        </div>
    @endauth

    {{-- Description --}}
    @if(!empty($game['description_raw']))
        <div class="card-glass p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                Descripción
            </h2>
            <div class="text-slate-300 leading-relaxed prose prose-invert max-w-none">
                {!! $game['description_raw'] !!}
            </div>
        </div>
    @endif

    {{-- Tags --}}
    @if(!empty($game['tags']))
        <div class="card-glass p-6 mb-8">
            <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center">
                <span class="w-2 h-2 bg-cyan-400 rounded-full mr-3"></span>
                Etiquetas
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach(array_slice($game['tags'], 0, 12) as $tag)
                    <span class="px-3 py-1 bg-slate-700/50 text-slate-300 text-sm rounded-full border border-slate-600">
                        {{ $tag['name'] }}
                    </span>
                @endforeach
                @if(count($game['tags']) > 12)
                    <span class="px-3 py-1 bg-slate-600/50 text-slate-400 text-sm rounded-full">
                        +{{ count($game['tags']) - 12 }} más
                    </span>
                @endif
            </div>
        </div>
    @endif

    {{-- System Requirements --}}
    @if(!empty($game['platforms']))
        @php
            $hasRequirements = false;
            foreach ($game['platforms'] as $platform) {
                if (!empty($platform['requirements']['minimum']) || !empty($platform['requirements']['recommended'])) {
                    $hasRequirements = true;
                    break;
                }
            }
        @endphp
        
        @if($hasRequirements)
            <div class="card-glass p-6">
                <h3 class="text-lg font-bold text-slate-100 mb-6 flex items-center">
                    <span class="w-2 h-2 bg-red-400 rounded-full mr-3"></span>
                    Requisitos del sistema
                </h3>
                
                <div class="space-y-6">
                    @foreach ($game['platforms'] as $platform)
                        @if(!empty($platform['requirements']['minimum']) || !empty($platform['requirements']['recommended']))
                            <div class="bg-slate-800/50 rounded-lg p-6 border border-slate-600">
                                <h4 class="font-bold text-slate-200 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $platform['platform']['name'] }}
                                </h4>
                                
                                <div class="grid md:grid-cols-2 gap-6">
                                    @if(!empty($platform['requirements']['minimum']))
                                        <div>
                                            <h5 class="font-semibold text-green-400 mb-3">Requisitos mínimos</h5>
                                            <div class="text-slate-300 text-sm leading-relaxed">
                                                {!! $platform['requirements']['minimum'] !!}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if(!empty($platform['requirements']['recommended']))
                                        <div>
                                            <h5 class="font-semibold text-purple-400 mb-3">Requisitos recomendados</h5>
                                            <div class="text-slate-300 text-sm leading-relaxed">
                                                {!! $platform['requirements']['recommended'] !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection