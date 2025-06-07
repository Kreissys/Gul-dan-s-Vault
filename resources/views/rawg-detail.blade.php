@extends('layouts.app')

@section('title', $game['name'] . ' - Detalle del Juego')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow max-w-4xl mt-6">
    <a href="{{ route('rawg.search', ['q' => $query]) }}" class="text-blue-500 hover:underline mb-4 inline-block">&larr; Volver a resultados</a>

    {{-- Mensajes de éxito/error --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex gap-6">
        @if(!empty($game['background_image']))
            <img src="{{ $game['background_image'] }}" alt="Imagen de {{ $game['name'] }}" class="w-80 h-auto rounded">
        @endif

        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-2">{{ $game['name'] }}</h1>
            <p><strong>Lanzamiento:</strong> {{ $game['released'] ?? 'Desconocido' }}</p>
            <p><strong>Duración Aproximada:</strong> {{ $game['playtime'] ?? 'N/A' }} horas</p>
            <p><strong>Géneros:</strong>
                {{ !empty($game['genres']) ? implode(', ', array_map(fn($g) => $g['name'], $game['genres'])) : 'No disponible' }}
            </p>
            <p><strong>Plataformas:</strong>
                {{ !empty($game['platforms']) ? implode(', ', array_map(fn($p) => $p['platform']['name'], $game['platforms'])) : 'No disponible' }}
            </p>
            <p><strong>Desarrolladores:</strong>
                {{ !empty($game['developers']) ? implode(', ', array_map(fn($d) => $d['name'], $game['developers'])) : 'No disponible' }}
            </p>
            <p><strong>Metacritic:</strong> {{ $game['metacritic'] ?? 'No disponible' }}</p>

            @if(!empty($game['tags']))
                <p><strong>Etiquetas:</strong> {{ implode(', ', array_map(fn($t) => $t['name'], $game['tags'])) }}</p>
            @endif

            <div class="mt-2">
                <span class="mr-4"><strong>Positivas:</strong> {{ $game['rating_top'] ?? 'N/A' }}</span>
                <span><strong>Usuarios que tienen el juego:</strong> {{ $game['added'] ?? 'N/A' }}</span>
            </div>

            @if(!empty($game['website']))
                <p class="mt-2"><strong>Sitio oficial:</strong>
                    <a href="{{ $game['website'] }}" class="text-blue-600 hover:underline" target="_blank">{{ $game['website'] }}</a>
                </p>
            @endif

            {{-- Botón para agregar a biblioteca --}}
            @auth
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    @if($inLibrary)
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-green-600 font-semibold">✓ Ya está en tu biblioteca</span>
                                <p class="text-sm text-gray-600">Estado: {{ $userGame->status_text }}</p>
                                @if($userGame->rating)
                                    <p class="text-sm text-gray-600">Tu puntuación: {{ $userGame->rating }}/10</p>
                                @endif
                            </div>
                            <a href="{{ route('games.show', $userGame) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Ver en biblioteca
                            </a>
                        </div>
                    @else
                        <h3 class="font-bold mb-3">Agregar a mi biblioteca</h3>
                        <form method="POST" action="{{ route('games.store') }}">
                            @csrf
                            <input type="hidden" name="rawg_id" value="{{ $game['id'] }}">
                            <input type="hidden" name="rawg_slug" value="{{ $game['slug'] }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                    <select name="status" required class="w-full border rounded px-3 py-2">
                                        <option value="">Seleccionar estado</option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="jugando">Jugando</option>
                                        <option value="completado">Completado</option>
                                        <option value="abandonado">Abandonado</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Puntuación (opcional)</label>
                                    <select name="rating" class="w-full border rounded px-3 py-2">
                                        <option value="">Sin puntuación</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}/10</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 mt-4">
                                Agregar a mi biblioteca
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="mt-6 p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-gray-600 mb-3">Inicia sesión para agregar juegos a tu biblioteca</p>
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Iniciar sesión
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Descripción</h2>
        <p>{!! $game['description_raw'] ?? 'No disponible' !!}</p>
    </div>

    @if(!empty($game['platforms']))
        <div class="mt-6 bg-gray-100 p-4 rounded">
            <h3 class="font-bold mb-2">Requisitos (si están disponibles)</h3>
            @foreach ($game['platforms'] as $platform)
                @if(!empty($platform['requirements']['minimum']))
                    <p><strong>{{ $platform['platform']['name'] }} - Mínimos:</strong> {!! $platform['requirements']['minimum'] !!}</p>
                @endif
                @if(!empty($platform['requirements']['recommended']))
                    <p><strong>{{ $platform['platform']['name'] }} - Recomendados:</strong> {!! $platform['requirements']['recommended'] !!}</p>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection