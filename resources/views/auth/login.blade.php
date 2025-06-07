<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Dynamic Gaming Background -->
        <div id="background-container" class="absolute inset-0 transition-all duration-1000">
            <!-- Fallback gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-purple-900 to-black"></div>
            <!-- Dynamic background will be loaded here -->
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <!-- Animated Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-2 h-2 bg-green-400 rounded-full animate-pulse" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="absolute w-1 h-1 bg-purple-400 rounded-full animate-pulse" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
            <div class="absolute w-3 h-3 bg-red-400 rounded-full animate-pulse" style="top: 80%; left: 20%; animation-delay: 2s;"></div>
            <div class="absolute w-1 h-1 bg-blue-400 rounded-full animate-pulse" style="top: 30%; left: 70%; animation-delay: 3s;"></div>
        </div>

        <div class="relative max-w-md w-full mx-4 z-10">
            <!-- Brand Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-600 via-purple-700 to-red-700 rounded-full shadow-2xl mb-4 transform hover:scale-110 transition-all duration-300 border-4 border-green-400/30">
                    <!-- Skull/Dark Magic Icon -->
                    <svg class="w-12 h-12 text-green-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1s1-.45 1-1v-1.26c.64.16 1.31.26 2 .26s1.36-.1 2-.26V17c0 .55.45 1 1 1s1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zM9 9c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                        <path d="M12 12c-1.1 0-2 .9-2 2v2h4v-2c0-1.1-.9-2-2-2z"/>
                    </svg>
                </div>
                
                <h1 class="text-5xl font-bold mb-2 bg-gradient-to-r from-green-400 via-purple-400 to-red-400 bg-clip-text text-transparent animate-pulse">
                    Gul'dan's Vault
                </h1>
                <p class="text-gray-300 text-lg font-medium">
                    <span class="text-purple-400">Donde los</span> 
                    <span class="text-green-400">juegos</span> 
                    <span class="text-red-400">cobran vida</span>
                </p>
                <p class="text-gray-500 text-sm mt-1">El poder de la biblioteca definitiva</p>
            </div>

            <!-- Login Card -->
            <div class="bg-black/40 backdrop-blur-xl rounded-2xl shadow-2xl border border-green-500/20 p-8 relative overflow-hidden">
                <!-- Mystical Border Effect -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-green-500/10 via-purple-500/10 to-red-500/10 animate-pulse"></div>
                
                <div class="relative z-10">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-white mb-2">Invocar Sesión</h2>
                        <p class="text-gray-400">El poder te aguarda, campeón</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <x-input-label for="email" class="text-gray-200 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Grimorio Élfico (Email)
                            </x-input-label>
                            <x-text-input id="email" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-green-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400/50" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autofocus 
                                        autocomplete="username" 
                                        placeholder="warlock@azeroth.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <x-input-label for="password" class="text-gray-200 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Hechizo Secreto (Contraseña)
                            </x-input-label>
                            <x-text-input id="password" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-purple-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-400/50"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="current-password" 
                                        placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                                <input id="remember_me" type="checkbox" class="rounded border-green-500/30 bg-black/30 text-green-500 focus:ring-green-500 focus:ring-offset-0" name="remember">
                                <span class="ml-2 text-sm text-gray-300 group-hover:text-green-400 transition-colors">Recordar alma</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-purple-400 hover:text-purple-300 transition-colors duration-200 hover:underline" href="{{ route('password.request') }}">
                                    ¿Hechizo olvidado?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="space-y-4">
                            <x-primary-button class="w-full justify-center py-4 bg-gradient-to-r from-green-600 via-purple-600 to-red-600 hover:from-green-700 hover:via-purple-700 hover:to-red-700 text-white font-bold text-lg rounded-lg shadow-2xl transform hover:scale-105 transition-all duration-300 border border-green-500/30 hover:border-green-400/50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                {{ __('Invocar Poder') }}
                            </x-primary-button>

                            <!-- Register Link -->
                            @if (Route::has('register'))
                                <div class="text-center">
                                    <span class="text-gray-400">¿Nuevo en Azeroth?</span>
                                    <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-medium transition-colors duration-200 ml-1 hover:underline">
                                        Forja tu destino
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    © 2024 Gul'dan's Vault. 
                    <span class="text-purple-400">Powered by dark magic</span> ⚡
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations and effects */
        @keyframes mystical-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 197, 94, 0.3); }
            50% { box-shadow: 0 0 30px rgba(147, 51, 234, 0.4), 0 0 40px rgba(239, 68, 68, 0.3); }
        }
        
        .animate-mystical {
            animation: mystical-glow 3s ease-in-out infinite;
        }
        
        /* Smooth focus transitions */
        input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
        }
        
        /* Background transitions */
        #background-container {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Mystical particle effects */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(120deg); }
            66% { transform: translateY(5px) rotate(240deg); }
        }
        
        .animate-pulse {
            animation: float 4s ease-in-out infinite;
        }
    </style>

    <script>
        // Dynamic background loader using RAWG API
        document.addEventListener('DOMContentLoaded', function() {
            loadRandomGameBackground();
        });

        async function loadRandomGameBackground() {
            try {
                // Array of popular dark/fantasy games for better backgrounds
                const gameQueries = [
                    'witcher', 'dark souls', 'skyrim', 'diablo', 'warcraft', 
                    'doom', 'cyberpunk', 'destiny', 'bloodborne', 'hollow knight'
                ];
                
                const randomQuery = gameQueries[Math.floor(Math.random() * gameQueries.length)];
                const apiKey = '{{ env("RAWG_API_KEY") }}';
                
                const response = await fetch(`https://api.rawg.io/api/games?key=${apiKey}&search=${randomQuery}&page_size=5`);
                const data = await response.json();
                
                if (data.results && data.results.length > 0) {
                    const randomGame = data.results[Math.floor(Math.random() * data.results.length)];
                    
                    if (randomGame.background_image) {
                        const backgroundContainer = document.getElementById('background-container');
                        const img = new Image();
                        
                        img.onload = function() {
                            backgroundContainer.style.backgroundImage = `url('${randomGame.background_image}')`;
                            backgroundContainer.style.filter = 'brightness(0.3) contrast(1.2) saturate(1.1)';
                        };
                        
                        img.src = randomGame.background_image;
                    }
                }
            } catch (error) {
                console.log('Using fallback background');
            }
        }
    </script>
</x-guest-layout>