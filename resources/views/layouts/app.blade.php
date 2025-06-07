<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Gul\'dan Vault\'s - Tu Biblioteca de Videojuegos')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-dark: #0f172a;
            --primary-medium: #1e293b;
            --primary-light: #334155;
            --accent-green: #10b981;
            --accent-purple: #8b5cf6;
            --accent-orange: #f97316;
            --text-light: #f1f5f9;
            --text-gray: #94a3b8;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
        }

        .brand-font {
            font-family: 'Orbitron', monospace;
        }

        .card-glass {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(51, 65, 85, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 16px;
        }

        .nav-glass {
            background: rgba(15, 23, 42, 0.9);
            border-bottom: 1px solid rgba(51, 65, 85, 0.3);
            backdrop-filter: blur(15px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-green) 0%, var(--accent-purple) 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .game-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(51, 65, 85, 0.3);
        }

        .game-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-green);
        }

        .search-glow:focus {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>

<body class="text-slate-100">
    <div id="app" class="min-h-screen">
        <!-- Navigation -->
        <nav class="nav-glass fixed w-full top-0 z-40" x-data="{ mobileOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-xl font-bold text-white">🏛️</span>
                                </div>
                                <span class="brand-font text-xl font-bold bg-gradient-to-r from-green-400 to-purple-400 bg-clip-text text-transparent">
                                    Gul'dan Vault's
                                </span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        @auth
                        <div class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="{{ route('dashboard') }}" 
                               class="text-slate-300 hover:text-green-400 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                      {{ request()->routeIs('dashboard') ? 'text-green-400 bg-slate-800' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('games.index') }}" 
                               class="text-slate-300 hover:text-green-400 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                      {{ request()->routeIs('games.*') ? 'text-green-400 bg-slate-800' : '' }}">
                                Mi Biblioteca
                            </a>
                            <a href="{{ route('rawg.search') }}" 
                               class="text-slate-300 hover:text-green-400 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                      {{ request()->routeIs('rawg.*') ? 'text-green-400 bg-slate-800' : '' }}">
                                Buscar Juegos
                            </a>
                        </div>
                        @endauth
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-slate-300 hover:text-green-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Registrarse
                            </a>
                        @else
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-slate-300 hover:text-green-400 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                    </div>
                                    <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition
                                     class="absolute right-0 mt-2 w-48 card-glass rounded-md shadow-lg py-1">
                                    <a href="{{ route('profile.edit') }}" 
                                       class="block px-4 py-2 text-sm text-slate-300 hover:text-green-400 hover:bg-slate-700 transition-colors">
                                        Perfil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-slate-300 hover:text-red-400 hover:bg-slate-700 transition-colors">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest

                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button type="button" class="text-slate-300 hover:text-green-400" @click="mobileOpen = !mobileOpen">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                @auth
                <div x-show="mobileOpen" x-transition class="md:hidden bg-slate-900/95 border-t border-slate-700">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-green-400 hover:bg-slate-800 transition-colors
                                  {{ request()->routeIs('dashboard') ? 'text-green-400 bg-slate-800' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('games.index') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-green-400 hover:bg-slate-800 transition-colors
                                  {{ request()->routeIs('games.*') ? 'text-green-400 bg-slate-800' : '' }}">
                            Mi Biblioteca
                        </a>
                        <a href="{{ route('rawg.search') }}" 
                           class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-green-400 hover:bg-slate-800 transition-colors
                                  {{ request()->routeIs('rawg.*') ? 'text-green-400 bg-slate-800' : '' }}">
                            Buscar Juegos
                        </a>
                    </div>
                    
                    <!-- Mobile user menu -->
                    <div class="pt-4 pb-3 border-t border-slate-700">
                        <div class="flex items-center px-5">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 2) }}</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-slate-200">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-slate-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-green-400 hover:bg-slate-800 transition-colors">
                                Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-red-400 hover:bg-slate-800 transition-colors">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-16 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-900/50 border border-green-500 text-green-100 slide-in">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-lg bg-red-900/50 border border-red-500 text-red-100 slide-in">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-900/50 border border-red-500 text-red-100 slide-in">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold mb-2">Se encontraron errores:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Floating Action Button (for quick search) -->
        @auth
        <div class="floating-action">
            <a href="{{ route('rawg.search') }}" 
               class="btn-primary w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </a>
        </div>
        @endauth
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>