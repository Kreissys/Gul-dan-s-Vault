@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto slide-in">
    <div class="mb-6">
        <a href="{{ route('games.index') }}" class="text-green-400 hover:text-green-300 mb-4 inline-flex items-center gap-2 transition-colors duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a mi biblioteca
        </a>
        <h1 class="text-3xl font-bold text-slate-100 brand-font">{{ $game->title }}</h1>
    </div>

    {{-- Mensajes de éxito/error --}}
    @if (session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Imagen y información básica --}}
        <div class="lg:col-span-1">
            <div class="card-glass overflow-hidden">
                @if($game->image)
                    <div class="relative">
                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-slate-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-slate-400">Sin imagen</span>
                        </div>
                    </div>
                @endif
                
                <div class="p-6">
                    <div class="mb-4">
                        <span class="status-badge px-4 py-2 rounded-full text-sm font-medium text-white {{ $game->status_color }}">
                            {{ $game->status_text }}
                        </span>
                    </div>
                    
                    @if($game->rating)
                        <div class="mb-4 p-4 bg-slate-700/50 rounded-lg border border-slate-600">
                            <span class="text-sm text-slate-400 block mb-1">Tu puntuación:</span>
                            <div class="flex items-center">
                                <span class="text-yellow-400 text-xl mr-2">★</span>
                                <span class="text-xl font-bold text-slate-100">{{ $game->rating }}/10</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="space-y-3 text-sm">
                        @if($game->release_date)
                            <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <span class="text-slate-400">Lanzamiento:</span>
                                    <span class="text-slate-100 font-medium ml-2">{{ $game->release_date->format('Y') }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($game->hours_played > 0)
                            <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <span class="text-slate-400">Horas jugadas:</span>
                                    <span class="text-slate-100 font-medium ml-2">{{ $game->hours_played }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($game->playtime > 0)
                            <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <div>
                                    <span class="text-slate-400">Duración estimada:</span>
                                    <span class="text-slate-100 font-medium ml-2">{{ $game->playtime }} horas</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($game->metacritic_score)
                            <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg">
                                <div class="w-6 h-6 bg-yellow-500 text-black text-xs font-bold rounded flex items-center justify-center">
                                    M
                                </div>
                                <div>
                                    <span class="text-slate-400">Metacritic:</span>
                                    <span class="text-slate-100 font-medium ml-2">{{ $game->metacritic_score }}/100</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($game->genres)
                        <div class="mt-6">
                            <p class="text-sm font-medium text-slate-300 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                                Géneros:
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($game->genres as $genre)
                                    <span class="px-3 py-1 bg-gradient-to-r from-purple-500/20 to-green-500/20 text-slate-300 text-xs rounded-full border border-purple-500/30">
                                        {{ $genre }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if($game->platforms)
                        <div class="mt-6">
                            <p class="text-sm font-medium text-slate-300 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                Plataformas:
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($game->platforms as $platform)
                                    <span class="px-3 py-1 bg-slate-700/50 text-slate-300 text-xs rounded-full border border-slate-600">
                                        {{ $platform }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Formulario de edición y notas --}}
        <div class="lg:col-span-2">
            <div class="card-glass p-6">
                <h2 class="text-xl font-bold text-slate-100 mb-6 flex items-center gap-3">
                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                    Actualizar información
                </h2>
                
                <form method="POST" action="{{ route('games.update', $game) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Estado</label>
                            <select name="status" required class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-slate-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="pendiente" {{ $game->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="jugando" {{ $game->status === 'jugando' ? 'selected' : '' }}>Jugando</option>
                                <option value="completado" {{ $game->status === 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="abandonado" {{ $game->status === 'abandonado' ? 'selected' : '' }}>Abandonado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Puntuación</label>
                            <select name="rating" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-slate-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Sin puntuación</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $game->rating == $i ? 'selected' : '' }}>{{ $i }}/10</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Horas jugadas</label>
                        <input type="number" 
                               name="hours_played" 
                               value="{{ $game->hours_played }}" 
                               min="0" 
                               step="0.5"
                               class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Notas personales</label>
                        <textarea name="notes" 
                                  rows="4" 
                                  placeholder="Escribe tus notas sobre este juego..."
                                  class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none">{{ $game->notes }}</textarea>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Actualizar
                        </button>
                        
                        <a href="{{ route('rawg.show', ['slug' => $game->rawg_slug]) }}" 
                           class="bg-slate-700 hover:bg-slate-600 text-slate-100 px-6 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition-all duration-300 border border-slate-600 hover:border-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Ver en RAWG
                        </a>
                    </div>
                </form>
            </div>
            
            {{-- Notas del usuario --}}
            @if($game->notes)
                <div class="card-glass p-6 mt-6">
                    <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center gap-3">
                        <span class="w-2 h-2 bg-orange-400 rounded-full"></span>
                        Mis notas
                    </h3>
                    <div class="bg-slate-700/30 rounded-lg p-4 border border-slate-600">
                        <p class="text-slate-300 whitespace-pre-line leading-relaxed">{{ $game->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Botón eliminar --}}
    <div class="mt-8 text-center">
        <form method="POST" action="{{ route('games.destroy', $game) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('¿Estás seguro de eliminar este juego de tu biblioteca? Esta acción no se puede deshacer.')"
                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 border border-red-500/50 hover:border-red-400 px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Eliminar de mi biblioteca
            </button>
        </form>
    </div>
</div>
@endsection