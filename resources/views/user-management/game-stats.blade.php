@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 slide-in">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">Estadísticas de Juegos</h1>
            <a href="{{ route('user-management.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Volver a Gestión de Usuarios
            </a>
        </div>
    </div>

    {{-- Información del usuario --}}
    <div class="card-glass p-6 mb-8">
        <div class="flex items-center gap-6">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-purple-600">
                <img src="{{ $user->profile_photo_url }}" 
                     alt="{{ $user->name }}" 
                     class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-100 mb-2">{{ $user->name }}</h2>
                <p class="text-slate-400">{{ $user->email }}</p>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center gap-4">
                        <span class="text-slate-400">Rol:</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-purple-600/20 text-purple-400' : 'bg-blue-600/20 text-blue-400' }}">
                            {{ $user->role === 'admin' ? 'Administrador' : 'Usuario' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-slate-400">Google Sign-In:</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->google_id ? 'bg-blue-600/20 text-blue-400' : 'bg-gray-600/20 text-gray-400' }}">
                            {{ $user->google_id ? 'Sí' : 'No' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-slate-400">Verificado:</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->email_verified_at ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                            {{ $user->email_verified_at ? 'Sí' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
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
                                <span class="text-3xl">🎮</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-slate-100 mb-1">{{ $game->title }}</h3>
                        <div class="text-sm text-slate-400 mb-2">
                            {{ $game->platforms_string }}
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $game->status_color }}">
                                {{ $game->status_text }}
                            </span>
                            @if($game->rating)
                                <span class="px-2 py-1 text-xs rounded-full bg-orange-600/20 text-orange-400">
                                    {{ $game->rating }}/10
                                </span>
                            @endif
                        </div>
                        @if($game->hours_played)
                            <div class="text-sm text-slate-400 mb-2">
                                <span class="font-medium text-slate-100">Horas jugadas:</span>
                                {{ number_format($game->hours_played, 1) }}h
                            </div>
                        @endif
                        @if($game->notes)
                            <div class="text-sm text-slate-400">
                                <span class="font-medium text-slate-100">Notas:</span>
                                {{ $game->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-glass p-12 text-center slide-in">
            <div class="w-24 h-24 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl">🎮</span>
            </div>
            <h3 class="text-xl font-semibold text-slate-100 mb-2">Sin juegos agregados</h3>
            <p class="text-slate-400">Este usuario aún no ha agregado juegos a su biblioteca.</p>
        </div>
    @endif
</div>
@endsection
