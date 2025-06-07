@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Mi Perfil</h1>
        <p class="text-gray-600">Información personal y estadísticas de juegos</p>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            Perfil actualizado exitosamente.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Información del usuario --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Información Personal</h2>
                
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input id="name" name="name" type="text" 
                               value="{{ old('name', $user->name) }}" 
                               required autofocus autocomplete="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input id="email" name="email" type="email" 
                               value="{{ old('email', $user->email) }}" 
                               required autocomplete="username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-sm text-gray-800">
                                    Tu dirección de email no está verificada.
                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
                                        Haz clic aquí para reenviar el email de verificación.
                                    </button>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            {{-- Estadísticas rápidas --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Resumen</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Miembro desde:</span>
                        <span class="font-medium">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Juegos en biblioteca:</span>
                        <span class="font-medium text-blue-600">{{ $stats['total_games'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Horas totales:</span>
                        <span class="font-medium text-purple-600">{{ number_format($stats['total_hours'], 1) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tasa de finalización:</span>
                        <span class="font-medium text-green-600">{{ $stats['completion_rate'] }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas detalladas --}}
        <div class="lg:col-span-2">
            {{-- Estadísticas de juegos --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Estadísticas de Juegos</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_games'] }}</div>
                        <div class="text-sm text-gray-600">Total</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['completed_games'] }}</div>
                        <div class="text-sm text-gray-600">Completados</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['playing_games'] }}</div>
                        <div class="text-sm text-gray-600">Jugando</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-600">{{ $stats['pending_games'] }}</div>
                        <div class="text-sm text-gray-600">Pendientes</div>
                    </div>
                </div>

                {{-- Estadísticas adicionales --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold mb-2">Métricas</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Horas totales:</span>
                                <span class="font-medium">{{ number_format($stats['total_hours'], 1) }}h</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Promedio por juego:</span>
                                <span class="font-medium">
                                    {{ $stats['total_games'] > 0 ? number_format($stats['total_hours'] / $stats['total_games'], 1) : 0 }}h
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Rating promedio:</span>
                                <span class="font-medium">
                                    @if($stats['average_rating'])
                                        <span class="text-yellow-500">★</span> {{ number_format($stats['average_rating'], 1) }}/10
                                    @else
                                        No calificado
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-2">Géneros Favoritos</h3>
                        <div class="space-y-1">
                            @forelse($stats['favorite_genres'] as $genre => $count)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $genre }}</span>
                                    <span class="font-medium">{{ $count }} juegos</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No hay datos suficientes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Juegos recientes y favoritos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Actividad reciente --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Actividad Reciente</h3>
                    @if($recentGames->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentGames as $game)
                                <div class="flex items-center gap-3">
                                    @if($game->image)
                                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-xs text-gray-500">🎮</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium truncate">{{ $game->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $game->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 rounded text-xs text-white {{ $game->status_color }}">
                                        {{ $game->status_text }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay actividad reciente</p>
                    @endif
                </div>

                {{-- Juegos favoritos --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Juegos Favoritos</h3>
                    @if($favoriteGames->count() > 0)
                        <div class="space-y-3">
                            @foreach($favoriteGames as $game)
                                <div class="flex items-center gap-3">
                                    @if($game->image)
                                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-xs text-gray-500">🎮</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium truncate">{{ $game->title }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-yellow-500 text-sm">★</span>
                                            <span class="text-sm text-gray-600">{{ $game->rating }}/10</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No tienes juegos calificados aún</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de eliminar cuenta --}}
    <div class="mt-8 bg-red-50 rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-red-900 mb-4">Zona Peligrosa</h2>
        <p class="text-red-700 mb-4">Una vez que elimines tu cuenta, todos los datos serán borrados permanentemente.</p>
        
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Eliminar Cuenta
        </button>
    </div>
</div>

{{-- Modal para confirmar eliminación --}}
<div x-data="{ show: false }" x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md mx-auto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 mb-4">
                ¿Estás seguro de que quieres eliminar tu cuenta?
            </h2>

            <p class="text-sm text-gray-600 mb-4">
                Una vez que elimines tu cuenta, todos los recursos y datos serán borrados permanentemente. Por favor, ingresa tu contraseña para confirmar que quieres eliminar tu cuenta de forma permanente.
            </p>

            <div class="mb-6">
                <label for="password" class="sr-only">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="show = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar Cuenta
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts necesarios para el modal --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection