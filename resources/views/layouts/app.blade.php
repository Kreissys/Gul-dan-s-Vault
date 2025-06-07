<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'LibrarieGames') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">LibrarieGames</a>
                
                {{-- Navigation Links --}}
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : '' }}">
                        Inicio
                    </a>
                    <a href="{{ route('games.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('games.*') ? 'text-blue-600 font-semibold' : '' }}">
                        Mi Biblioteca
                    </a>
                    <a href="{{ route('rawg.search') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('rawg.*') ? 'text-blue-600 font-semibold' : '' }}">
                        Buscar Juegos
                    </a>
                </div>
                
                {{-- User Menu --}}
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-blue-600">
                            {{ Auth::user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-500">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                    
                    {{-- Mobile menu button --}}
                    <div class="md:hidden">
                        <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 py-2">Inicio</a>
                    <a href="{{ route('games.index') }}" class="text-gray-700 hover:text-blue-600 py-2">Mi Biblioteca</a>
                    <a href="{{ route('rawg.search') }}" class="text-gray-700 hover:text-blue-600 py-2">Buscar Juegos</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-blue-600 py-2">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-500 py-2">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="flex-1 pt-20 px-4 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t mt-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} LibrarieGames. Todos los derechos reservados.
        </div>
    </footer>

    {{-- Mobile menu toggle script --}}
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>