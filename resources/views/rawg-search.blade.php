@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Buscar Juegos</h1>

        <form method="GET" action="{{ route('rawg.search') }}" class="mb-6">
            <input
                type="text"
                name="q"
                placeholder="Nombre del juego"
                value="{{ request('q') }}"
                required
                class="px-4 py-2 border rounded w-full sm:w-96 mb-2 sm:mb-0 sm:mr-2"
            />
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Buscar
            </button>
        </form>

        @if ($errors->any())
            <div class="text-red-600 mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        @if(isset($results))
            <h2 class="text-xl font-semibold mb-4">Resultados para "{{ request('q') }}":</h2>

            <ul class="space-y-4">
                @forelse($results['results'] ?? [] as $game)
                    <li class="bg-white p-4 rounded-lg shadow-md flex gap-4 items-center">
                        @if(!empty($game['background_image']))
                            <img src="{{ $game['background_image'] }}" alt="Imagen de {{ $game['name'] }}" class="w-32 h-20 object-cover rounded" />
                        @else
                            <img src="https://via.placeholder.com/120x70?text=Sin+Imagen" alt="Sin imagen" class="w-32 h-20 object-cover rounded" />
                        @endif

                        <div class="flex-1">
                            <strong>
                                <a href="{{ route('rawg.show', ['slug' => $game['slug'], 'q' => request('q')]) }}" class="text-blue-600 hover:underline">
                                    {{ $game['name'] }}
                                </a>
                            </strong><br />
                            <span class="text-sm text-gray-600">
                                Lanzamiento: {{ $game['released'] ?? 'Desconocido' }}<br />
                                Duración aproximada: {{ $game['playtime'] ?? 'N/A' }} horas<br />
                                Plataformas:
                                @if(!empty($game['platforms']))
                                    {{ implode(', ', array_map(fn($p) => $p['platform']['name'], $game['platforms'])) }}
                                @else
                                    No disponible
                                @endif
                                <br />
                                Géneros:
                                @if(!empty($game['genres']))
                                    {{ implode(', ', array_map(fn($g) => $g['name'], $game['genres'])) }}
                                @else
                                    No disponible
                                @endif
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-600">No se encontraron resultados.</li>
                @endforelse
            </ul>
        @endif
    </div>
@endsection
