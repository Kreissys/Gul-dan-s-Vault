@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Mi Biblioteca de Juegos</h1>
        <p class="text-gray-600">Gestiona tu colección personal de videojuegos</p>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-600">Total</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['playing'] }}</div>
            <div class="text-sm text-gray-600">Jugando</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['completed'] }}</div>
            <div class="text-sm text-gray-600">Completados</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-gray-500">{{ $stats['pending'] }}</div>
            <div class="text-sm text-gray-600">Pendientes</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-red-500">{{ $stats['dropped'] }}</div>
            <div class="text-sm text-gray-600">Abandonados</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-purple-500">{{ $stats['total_hours'] }}</div>
            <div class="text-sm text-gray-600">Horas totales</div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('games.index') }}" 
               class="px-4 py-2 rounded-lg {{ !request('status') || request('status') === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Todos
            </a>
            <a href="{{ route('games.filter', ['status' => 'jugando']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'jugando' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Jugando
            </a>
            <a href="{{ route('games.filter', ['status' => 'completado']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'completado' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Completados
            </a>
            <a href="{{ route('games.filter', ['status' => 'pendiente']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'pendiente' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Pendientes
            </a>
            <a href="{{ route('games.filter', ['status' => 'abandonado']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'abandonado' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Abandonados
            </a>
        </div>
    </div>

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

    {{-- Lista de juegos --}}
    @if($games->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($games as $game)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($game->image)
                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">Sin imagen</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 truncate">{{ $game->title }}</h3>
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 rounded text-xs text-white {{ $game->status_color }}">
                                {{ $game->status_text }}
                            </span>
                            @if($game->rating)
                                <div class="flex items-center">
                                    <span class="text-yellow-500">★</span>
                                    <span class="ml-1 text-sm">{{ $game->rating }}/10</span>
                                </div>
                            @endif
                        </div>
                        
                        @if($game->hours_played > 0)
                            <p class="text-sm text-gray-600 mb-2">{{ $game->hours_played }} horas jugadas</p>
                        @endif
                        
                        <p class="text-xs text-gray-500 mb-3">{{ $game->genres_string }}</p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('games.show', $game) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 px-3 rounded text-sm hover:bg-blue-600">
                                Ver detalles
                            </a>
                            <form method="POST" action="{{ route('games.destroy', $game) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Estás seguro de eliminar este juego?')"
                                        class="bg-red-500 text-white py-2 px-3 rounded text-sm hover:bg-red-600">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <div class="text-gray-500 text-lg mb-4">
                @if(request('status') && request('status') !== 'all')
                    No tienes juegos con el estado "{{ ucfirst(request('status')) }}"
                @else
                    Tu biblioteca está vacía
                @endif
            </div>
            <a href="{{ route('rawg.search') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Buscar juegos para agregar
            </a>
        </div>
    @endif
</div>
@endsection