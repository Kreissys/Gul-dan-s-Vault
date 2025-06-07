@extends('layouts.app')

@section('title', 'Buscar Juegos - Gul\'dan Vault\'s')

@section('content')
<div class="slide-in">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold brand-font bg-gradient-to-r from-green-400 to-purple-400 bg-clip-text text-transparent mb-4">
            Descubre Nuevos Juegos
        </h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto">
            Explora miles de juegos y agrégalos a tu biblioteca personal
        </p>
    </div>

    <!-- Search Form -->
    <div class="card-glass p-6 mb-8 max-w-2xl mx-auto">
        <form method="GET" action="{{ route('rawg.search') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="q"
                    placeholder="Buscar juegos... (ej: The Witcher, GTA, Minecraft)"
                    value="{{ request('q') }}"
                    required
                    class="w-full pl-10 pr-4 py-3 bg-slate-800 border border-slate-600 rounded-lg text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent search-glow transition-all"
                />
            </div>
            <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium flex items-center justify-center gap-2 min-w-[120px]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Buscar
            </button>
        </form>
    </div>

    <!-- Results Section -->
    @if(isset($results))
        <div class="mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-100">
                    Resultados para "<span class="text-green-400">{{ request('q') }}</span>"
                </h2>
                <div class="text-slate-400">
                    {{ count($results['results'] ?? []) }} juegos encontrados
                </div>
            </div>

            @if(empty($results['results']))
                <div class="card-glass p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-slate-700 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.287 0-4.33.923-5.824 2.417"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-300 mb-2">No se encontraron juegos</h3>
                    <p class="text-slate-400">Intenta con otros términos de búsqueda</p>
                </div>
            @else
                <div class="grid gap-6">
                    @foreach($results['results'] as $game)
                        <div class="game-card card-glass p-6 flex flex-col lg:flex-row gap-6 items-start">
                            <!-- Game Image -->
                            <div class="flex-shrink-0">
                                @if(!empty($game['background_image']))
                                    <img src="{{ $game['background_image'] }}" 
                                         alt="{{ $game['name'] }}" 
                                         class="w-full lg:w-48 h-32 lg:h-28 object-cover rounded-lg shadow-lg" />
                                @else
                                    <div class="w-full lg:w-48 h-32 lg:h-28 bg-gradient-to-br from-slate-700 to-slate-800 rounded-lg shadow-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Game Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-100 mb-2">
                                            <a href="{{ route('rawg.show', ['slug' => $game['slug'], 'q' => request('q')]) }}" 
                                               class="hover:text-green-400 transition-colors">
                                                {{ $game['name'] }}
                                            </a>
                                        </h3>
                                        
                                        <!-- Quick Info -->
                                        <div class="flex flex-wrap gap-4 text-sm text-slate-400 mb-3">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $game['released'] ?? 'Fecha desconocida' }}
                                            </span>
                                            
                                            @if($game['playtime'])
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    ~{{ $game['playtime'] }}h
                                                </span>
                                            @endif

                                            @if($game['metacritic'])
                                                <span class="flex items-center gap-1">
                                                    <span class="w-6 h-6 bg-yellow-500 text-black text-xs font-bold rounded flex items-center justify-center">
                                                        M
                                                    </span>
                                                    {{ $game['metacritic'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Library Status -->
                                    @auth
                                        @if(isset($game['in_library']) && $game['in_library'])
                                            <div class="status-badge bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium border border-green-500/30">
                                                ✓ En tu biblioteca
                                            </div>
                                        @endif
                                    @endauth
                                </div>

                                <!-- Platforms -->
                                @if(!empty($game['platforms']))
                                    <div class="mb-3">
                                        <h4 class="text-sm font-medium text-slate-300 mb-2">Plataformas:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(array_slice($game['platforms'], 0, 4) as $platform)
                                                <span class="px-2 py-1 bg-slate-700 text-slate-300 text-xs rounded-md">
                                                    {{ $platform['platform']['name'] }}
                                                </span>
                                            @endforeach
                                            @if(count($game['platforms']) > 4)
                                                <span class="px-2 py-1 bg-slate-600 text-slate-400 text-xs rounded-md">
                                                    +{{ count($game['platforms']) - 4 }} más
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Genres -->
                                @if(!empty($game['genres']))
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-slate-300 mb-2">Géneros:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($game['genres'] as $genre)
                                                <span class="px-2 py-1 bg-gradient-to-r from-purple-500/20 to-green-500/20 text-slate-300 text-xs rounded-md border border-purple-500/30">
                                                    {{ $genre['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <div class="flex gap-3">
                                    <a href="{{ route('rawg.show', ['slug' => $game['slug'], 'q' => request('q')]) }}" 
                                       class="btn-primary px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Welcome State -->
        <div class="card-glass p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-green-400/20 to-purple-600/20 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-100 mb-4">¡Comienza tu búsqueda!</h3>
            <p class="text-slate-400 mb-6 max-w-md mx-auto">
                Usa el buscador para encontrar tus juegos favoritos y descubrir nuevos títulos para agregar a tu biblioteca.
            </p>
            <div class="flex flex-wrap justify-center gap-2 text-sm">
                <span class="px-3 py-1 bg-slate-700 text-slate-300 rounded-full">Sugerencias:</span>
                <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-full">The Witcher</span>
                <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-full">Cyberpunk</span>
                <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-full">Minecraft</span>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Auto-focus search input on page load
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>
@endpush
@endsection