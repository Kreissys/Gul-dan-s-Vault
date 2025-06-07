@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('games.index') }}" class="text-blue-500 hover:underline mb-4 inline-block">&larr; Volver a mi biblioteca</a>
        <h1 class="text-3xl font-bold text-gray-900">{{ $game->title }}</h1>
    </div>

    {{-- Mensajes de éxito/error --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Imagen y información básica --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($game->image)
                    <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Sin imagen</span>
                    </div>
                @endif
                
                <div class="p-4">
                    <div class="mb-4">
                        <span class="px-3 py-1 rounded-full text-sm text-white {{ $game->status_color }}">
                            {{ $game->status_text }}
                        </span>
                    </div>
                    
                    @if($game->rating)
                        <div class="mb-3">
                            <span class="text-sm text-gray-600">Tu puntuación:</span>
                            <div class="flex items-center">
                                <span class="text-yellow-500 text-lg">★</span>
                                <span class="ml-1 text-lg font-semibold">{{ $game->rating }}/10</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="space-y-2 text-sm">
                        @if($game->release_date)
                            <p><strong>Lanzamiento:</strong> {{ $game->release_date->format('Y') }}</p>
                        @endif
                        
                        @if($game->hours_played > 0)
                            <p><strong>Horas jugadas:</strong> {{ $game->hours_played }}</p>
                        @endif
                        
                        @if($game->playtime > 0)
                            <p><strong>Duración estimada:</strong> {{ $game->playtime }} horas</p>
                        @endif
                        
                        @if($game->metacritic_score)
                            <p><strong>Metacritic:</strong> {{ $game->metacritic_score }}/100</p>
                        @endif
                    </div>
                    
                    @if($game->genres)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Géneros:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($game->genres as $genre)
                                    <span class="px-2 py-1 bg-gray-100 text-xs rounded">{{ $genre }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if($game->platforms)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Plataformas:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($game->platforms as $platform)
                                    <span class="px-2 py-1 bg-blue-100 text-xs rounded">{{ $platform }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Formulario de edición y notas --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Actualizar información</h2>
                
                <form method="POST" action="{{ route('games.update', $game) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select name="status" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="pendiente" {{ $game->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="jugando" {{ $game->status === 'jugando' ? 'selected' : '' }}>Jugando</option>
                                <option value="completado" {{ $game->status === 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="abandonado" {{ $game->status === 'abandonado' ? 'selected' : '' }}>Abandonado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Puntuación</label>
                            <select name="rating" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sin puntuación</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $game->rating == $i ? 'selected' : '' }}>{{ $i }}/10</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Horas jugadas</label>
                        <input type="number" 
                               name="hours_played" 
                               value="{{ $game->hours_played }}" 
                               min="0" 
                               step="0.5"
                               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notas personales</label>
                        <textarea name="notes" 
                                  rows="4" 
                                  placeholder="Escribe tus notas sobre este juego..."
                                  class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $game->notes }}</textarea>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:ring-2 focus:ring-blue-500">
                            Actualizar
                        </button>
                        
                        <a href="{{ route('rawg.show', ['slug' => $game->rawg_slug]) }}" 
                           class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                            Ver en RAWG
                        </a>
                    </div>
                </form>
            </div>
            
            {{-- Notas del usuario --}}
            @if($game->notes)
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-bold mb-3">Mis notas</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $game->notes }}</p>
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
                    class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 focus:ring-2 focus:ring-red-500">
                Eliminar de mi biblioteca
            </button>
        </form>
    </div>
</div>
@endsection