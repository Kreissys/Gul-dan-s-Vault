@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto slide-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-100 mb-2 brand-font">Mi Perfil</h1>
        <p class="text-slate-400">Información personal y estadísticas de juegos</p>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 card-glass">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Perfil actualizado exitosamente.
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Información del usuario --}}
        <div class="lg:col-span-1">
            <div class="card-glass p-6 mb-6 slide-in">
                <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                    Información Personal
                </h2>
                
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nombre</label>
                        <input id="name" name="name" type="text" 
                               value="{{ old('name', $user->name) }}" 
                               required autofocus autocomplete="name"
                               class="w-full px-3 py-3 bg-slate-800 border border-slate-600 rounded-lg text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input id="email" name="email" type="email" 
                               value="{{ old('email', $user->email) }}" 
                               required autocomplete="username"
                               class="w-full px-3 py-3 bg-slate-800 border border-slate-600 rounded-lg text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 p-3 bg-yellow-500/20 border border-yellow-500/30 rounded-lg">
                                <p class="text-sm text-yellow-400">
                                    Tu dirección de email no está verificada.
                                    <button form="send-verification" class="underline text-sm text-yellow-300 hover:text-yellow-100 transition-colors">
                                        Haz clic aquí para reenviar el email de verificación.
                                    </button>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-slate-300 mb-2">Contraseña Actual</label>
                        <input id="current_password" name="current_password" type="password" 
                               autocomplete="current-password"
                               class="w-full px-3 py-3 bg-slate-800 border border-slate-600 rounded-lg text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-6 py-3 bg-green-500 hover:bg-green-400 text-white rounded-lg transition-colors">
                            Guardar Cambios
                        </button>
                        @if (session('status') === 'profile-updated')
                            <button type="button" class="px-6 py-3 bg-gray-500 hover:bg-gray-400 text-white rounded-lg transition-colors">
                                Cerrar
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Sección de foto de perfil --}}
            <div class="card-glass p-6 mb-6 slide-in">
                <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                    Foto de Perfil
                </h2>

                <div class="space-y-6">
                    <!-- Foto actual -->
                    <div class="flex items-center justify-center">
                        <div class="relative w-40 h-40 rounded-full overflow-hidden border-2 border-slate-700">
                            <img src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-col gap-4">
                        <!-- Botón cambiar foto -->
                        <button type="button" 
                                onclick="document.getElementById('photo').click()"
                                class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white rounded-lg transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Cambiar Foto
                        </button>
                        
                        <!-- Formulario de subir foto -->
                        <form action="{{ route('profile-photo.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input type="file" name="photo" id="photo" 
                                   accept="image/*"
                                   onchange="this.form.submit()">
                        </form>

                        <!-- Botón eliminar -->
                        @if ($user->profile_photo)
                            <form action="{{ route('profile-photo.destroy') }}" method="POST" class="flex justify-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-400 text-white rounded-lg transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Estadísticas rápidas --}}
            <div class="card-glass p-6 slide-in">
                <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center">
                    <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                    Resumen
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-slate-300">Miembro desde:</span>
                        </div>
                        <span class="font-medium text-slate-100">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">🎮</span>
                            </div>
                            <span class="text-slate-300">Juegos en biblioteca:</span>
                        </div>
                        <span class="font-medium text-green-400">{{ $stats['total_games'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">⏱️</span>
                            </div>
                            <span class="text-slate-300">Horas totales:</span>
                        </div>
                        <span class="font-medium text-purple-400">{{ number_format($stats['total_hours'], 1) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">✅</span>
                            </div>
                            <span class="text-slate-300">Tasa de finalización:</span>
                        </div>
                        <span class="font-medium text-yellow-400">{{ $stats['completion_rate'] }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas detalladas --}}
        <div class="lg:col-span-2">
            {{-- Estadísticas de juegos --}}
            <div class="card-glass p-6 mb-6 slide-in">
                <h2 class="text-xl font-bold text-slate-100 mb-4 flex items-center">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                    Estadísticas de Juegos
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-slate-700/50 rounded-lg border border-slate-600 hover:border-blue-400 transition-all duration-300">
                        <div class="text-2xl font-bold text-blue-400">{{ $stats['total_games'] }}</div>
                        <div class="text-sm text-slate-400">Total</div>
                    </div>
                    <div class="text-center p-4 bg-slate-700/50 rounded-lg border border-slate-600 hover:border-green-400 transition-all duration-300">
                        <div class="text-2xl font-bold text-green-400">{{ $stats['completed_games'] }}</div>
                        <div class="text-sm text-slate-400">Completados</div>
                    </div>
                    <div class="text-center p-4 bg-slate-700/50 rounded-lg border border-slate-600 hover:border-yellow-400 transition-all duration-300">
                        <div class="text-2xl font-bold text-yellow-400">{{ $stats['playing_games'] }}</div>
                        <div class="text-sm text-slate-400">Jugando</div>
                    </div>
                    <div class="text-center p-4 bg-slate-700/50 rounded-lg border border-slate-600 hover:border-gray-400 transition-all duration-300">
                        <div class="text-2xl font-bold text-slate-400">{{ $stats['pending_games'] }}</div>
                        <div class="text-sm text-slate-400">Pendientes</div>
                    </div>
                </div>

                {{-- Estadísticas adicionales --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-slate-700/30 rounded-lg border border-slate-600">
                        <h3 class="font-semibold mb-3 text-slate-200 flex items-center">
                            <span class="w-1.5 h-1.5 bg-purple-400 rounded-full mr-2"></span>
                            Métricas
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-2 bg-slate-800/50 rounded">
                                <span class="text-slate-400">Horas totales:</span>
                                <span class="font-medium text-slate-200">{{ number_format($stats['total_hours'], 1) }}h</span>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-slate-800/50 rounded">
                                <span class="text-slate-400">Promedio por juego:</span>
                                <span class="font-medium text-slate-200">
                                    {{ $stats['total_games'] > 0 ? number_format($stats['total_hours'] / $stats['total_games'], 1) : 0 }}h
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-slate-800/50 rounded">
                                <span class="text-slate-400">Rating promedio:</span>
                                <span class="font-medium text-slate-200">
                                    @if($stats['average_rating'])
                                        <span class="text-yellow-400">★</span> {{ number_format($stats['average_rating'], 1) }}/10
                                    @else
                                        <span class="text-slate-500">No calificado</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-700/30 rounded-lg border border-slate-600">
                        <h3 class="font-semibold mb-3 text-slate-200 flex items-center">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2"></span>
                            Géneros Favoritos
                        </h3>
                        <div class="space-y-2">
                            @forelse($stats['favorite_genres'] as $genre => $count)
                                <div class="flex justify-between items-center p-2 bg-slate-800/50 rounded">
                                    <span class="text-slate-400">{{ $genre }}</span>
                                    <span class="font-medium text-slate-200">{{ $count }} juegos</span>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm p-2">No hay datos suficientes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Juegos recientes y favoritos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Actividad reciente --}}
                <div class="card-glass p-6 slide-in">
                    <h3 class="text-lg font-semibold text-slate-100 mb-4 flex items-center">
                        <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
                        Actividad Reciente
                    </h3>
                    @if($recentGames->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentGames as $game)
                                <div class="flex items-center gap-3 p-3 bg-slate-700/50 rounded-lg hover:bg-slate-600/50 transition-all duration-300 group">
                                    @if($game->image)
                                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-12 h-12 object-cover rounded group-hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-slate-600 to-slate-700 rounded flex items-center justify-center">
                                            <span class="text-xs text-slate-400">🎮</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium truncate text-slate-200 group-hover:text-green-400 transition-colors">{{ $game->title }}</p>
                                        <p class="text-sm text-slate-400">{{ $game->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="status-badge px-2 py-1 rounded text-xs text-white {{ $game->status_color }}">
                                        {{ $game->status_text }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-slate-400">📊</span>
                            </div>
                            <p class="text-slate-500">No hay actividad reciente</p>
                        </div>
                    @endif
                </div>

                {{-- Juegos favoritos --}}
                <div class="card-glass p-6 slide-in">
                    <h3 class="text-lg font-semibold text-slate-100 mb-4 flex items-center">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></span>
                        Juegos Favoritos
                    </h3>
                    @if($favoriteGames->count() > 0)
                        <div class="space-y-3">
                            @foreach($favoriteGames as $game)
                                <div class="flex items-center gap-3 p-3 bg-slate-700/50 rounded-lg hover:bg-slate-600/50 transition-all duration-300 group">
                                    @if($game->image)
                                        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-12 h-12 object-cover rounded group-hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-slate-600 to-slate-700 rounded flex items-center justify-center">
                                            <span class="text-xs text-slate-400">🎮</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium truncate text-slate-200 group-hover:text-green-400 transition-colors">{{ $game->title }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-yellow-400 text-sm">★</span>
                                            <span class="text-sm text-slate-400">{{ $game->rating }}/10</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-slate-400">⭐</span>
                            </div>
                            <p class="text-slate-500">No tienes juegos calificados aún</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de eliminar cuenta --}}
    <div class="mt-8 card-glass p-6 border-l-4 border-red-500 slide-in">
        <h2 class="text-xl font-bold text-red-400 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            Zona Peligrosa
        </h2>
        <p class="text-slate-400 mb-4">Una vez que elimines tu cuenta, todos los datos serán borrados permanentemente.</p>
        
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                class="bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Eliminar Cuenta
        </button>
    </div>
</div>

{{-- Modal para confirmar eliminación --}}
<div x-data="{ show: false }" x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black opacity-75"></div>
    </div>

    <div x-show="show" class="mb-6 card-glass rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md mx-auto border border-slate-600" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-slate-100">
                    ¿Estás seguro de que quieres eliminar tu cuenta?
                </h2>
            </div>

            <p class="text-sm text-slate-400 mb-4">
                Una vez que elimines tu cuenta, todos los recursos y datos serán borrados permanentemente. Por favor, ingresa tu contraseña para confirmar que quieres eliminar tu cuenta de forma permanente.
            </p>

            <div class="mb-6">
                <label for="password" class="sr-only">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña" 
                       class="w-full px-3 py-3 bg-slate-800 border border-slate-600 rounded-lg text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="show = false" 
                        class="px-4 py-2 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-all font-medium">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar Cuenta
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts necesarios para el modal --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection