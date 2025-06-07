@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 slide-in">
        <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">Mi Biblioteca de Juegos</h1>
        <p class="text-slate-400">Gestiona tu colección personal de videojuegos</p>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-slate-100">{{ $stats['total'] }}</div>
            <div class="text-sm text-slate-400">Total</div>
        </div>
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-blue-400">{{ $stats['playing'] }}</div>
            <div class="text-sm text-slate-400">Jugando</div>
        </div>
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-green-400">{{ $stats['completed'] }}</div>
            <div class="text-sm text-slate-400">Completados</div>
        </div>
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-slate-300">{{ $stats['pending'] }}</div>
            <div class="text-sm text-slate-400">Pendientes</div>
        </div>
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-red-400">{{ $stats['dropped'] }}</div>
            <div class="text-sm text-slate-400">Abandonados</div>
        </div>
        <div class="card-glass p-4 text-center slide-in">
            <div class="text-2xl font-bold text-purple-400">
                @php
                    $totalHoursRaw = $stats['total_hours'];
                    $totalHours = $totalHoursRaw instanceof \MongoDB\BSON\Decimal128 ? (float) $totalHoursRaw->__toString() : (float) $totalHoursRaw;
                @endphp
                {{ number_format($totalHours, 1) }}
            </div>
            <div class="text-sm text-slate-400">Horas totales</div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card-glass p-6 mb-8 slide-in">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('games.index') }}" 
               class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ !request('status') || request('status') === 'all' ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 hover:text-green-400 border border-slate-600 hover:border-green-400' }}">
                Todos
            </a>
            <a href="{{ route('games.filter', ['status' => 'jugando']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ request('status') === 'jugando' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 hover:text-blue-400 border border-slate-600 hover:border-blue-400' }}">
                Jugando
            </a>
            <a href="{{ route('games.filter', ['status' => 'completado']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ request('status') === 'completado' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 hover:text-green-400 border border-slate-600 hover:border-green-400' }}">
                Completados
            </a>
            <a href="{{ route('games.filter', ['status' => 'pendiente']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ request('status') === 'pendiente' ? 'bg-gradient-to-r from-slate-500 to-slate-600 text-white shadow-lg' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 hover:text-slate-200 border border-slate-600 hover:border-slate-400' }}">
                Pendientes
            </a>
            <a href="{{ route('games.filter', ['status' => 'abandonado']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ request('status') === 'abandonado' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 hover:text-red-400 border border-slate-600 hover:border-red-400' }}">
                Abandonados
            </a>
        </div>
    </div>

    {{-- Mensajes de éxito/error --}}
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-6 py-4 rounded-lg mb-6 slide-in backdrop-blur-sm">
            <div class="flex items-center">
                <span class="text-green-400 mr-2">✓</span>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-400/30 text-red-300 px-6 py-4 rounded-lg mb-6 slide-in backdrop-blur-sm">
            <div class="flex items-center">
                <span class="text-red-400 mr-2">✗</span>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Lista de juegos --}}
    @if($games->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($games as $game)
                <div class="card-glass overflow-hidden hover:scale-105 transition-all duration-300 group slide-in">
                    <div class="relative overflow-hidden">
                        @if($game->image)
                            <img src="{{ $game->image }}" alt="{{ $game->title }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center group-hover:from-slate-500 group-hover:to-slate-600 transition-colors duration-300">
                                <span class="text-slate-400">Sin imagen</span>
                            </div>
                        @endif
                        
                        {{-- Status badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium text-white backdrop-blur-sm {{ $game->status_color }}">
                                {{ $game->status_text }}
                            </span>
                        </div>
                        
                        {{-- Rating badge --}}
                        @if($game->rating)
                            <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-sm rounded-full px-2 py-1">
                                <div class="flex items-center text-yellow-400">
                                    <span class="text-sm">★</span>
                                    <span class="ml-1 text-xs text-white">{{ $game->rating }}/10</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <h3 class="font-bold text-lg mb-3 text-slate-100 truncate group-hover:text-green-400 transition-colors">
                            {{ $game->title }}
                        </h3>
                        
                        @if($game->hours_played > 0)
                            <p class="text-sm text-slate-400 mb-2 flex items-center">
                                <span class="text-purple-400 mr-2">⏱️</span>
                                @php
                                    $hoursRaw = $game->hours_played;
                                    $hours = $hoursRaw instanceof \MongoDB\BSON\Decimal128 ? (float) $hoursRaw->__toString() : (float) $hoursRaw;
                                @endphp
                                {{ number_format($hours, 1) }} horas jugadas
                            </p>
                        @endif
                        
                        @if($game->genres_string)
                            <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $game->genres_string }}</p>
                        @endif
                        
                        <div class="flex gap-2">
                            <a href="{{ route('games.show', $game) }}" 
                               class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-2 px-3 rounded-lg text-sm font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                                Ver detalles
                            </a>
                            <form method="POST" action="{{ route('games.destroy', $game) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Estás seguro de eliminar este juego?')"
                                        class="bg-gradient-to-r from-red-500 to-red-600 text-white py-2 px-3 rounded-lg text-sm hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-red-500/25">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-glass p-12 text-center slide-in">
            <div class="w-24 h-24 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl">🎮</span>
            </div>
            <div class="text-slate-300 text-xl mb-2">
                @if(request('status') && request('status') !== 'all')
                    No tienes juegos con el estado "{{ ucfirst(request('status')) }}"
                @else
                    Tu biblioteca está vacía
                @endif
            </div>
            <p class="text-slate-500 mb-6">
                @if(request('status') && request('status') !== 'all')
                    Prueba cambiando el filtro o agrega nuevos juegos a tu colección
                @else
                    Comienza agregando algunos juegos a tu biblioteca personal
                @endif
            </p>
            <a href="{{ route('rawg.search') }}" 
               class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-lg font-medium hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-green-500/25 inline-flex items-center space-x-2">
                <span>🔍</span>
                <span>Buscar juegos para agregar</span>
            </a>
        </div>
    @endif
</div>
@endsection