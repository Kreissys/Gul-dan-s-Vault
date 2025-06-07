<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Dynamic Gaming Background -->
        <div id="background-container" class="absolute inset-0 transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-purple-900 to-black"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <!-- Animated Runes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute text-green-400/20 text-6xl animate-float-1" style="top: 15%; left: 5%;">⚡</div>
            <div class="absolute text-purple-400/20 text-4xl animate-float-2" style="top: 70%; left: 85%;">🔮</div>
            <div class="absolute text-red-400/20 text-5xl animate-float-3" style="top: 80%; left: 10%;">💀</div>
            <div class="absolute text-blue-400/20 text-3xl animate-float-4" style="top: 25%; left: 80%;">⭐</div>
            <div class="absolute text-yellow-400/20 text-4xl animate-float-5" style="top: 45%; left: 15%;">🗡️</div>
            <div class="absolute text-cyan-400/20 text-3xl animate-float-6" style="top: 60%; left: 90%;">🌟</div>
        </div>

        <div class="relative max-w-md w-full mx-4 z-10">
            <!-- Brand Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-600 via-purple-700 to-red-700 rounded-full shadow-2xl mb-4 transform hover:scale-110 transition-all duration-300 border-4 border-green-400/30 animate-mystical-glow">
                    <!-- Gul'dan Skull Icon -->
                    <svg class="w-12 h-12 text-green-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1s1-.45 1-1v-1.26c.64.16 1.31.26 2 .26s1.36-.1 2-.26V17c0 .55.45 1 1 1s1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zM9 9c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                        <path d="M12 12c-1.1 0-2 .9-2 2v2h4v-2c0-1.1-.9-2-2-2z"/>
                    </svg>
                </div>
                
                <h1 class="text-5xl font-bold mb-2 bg-gradient-to-r from-green-400 via-purple-400 to-red-400 bg-clip-text text-transparent animate-pulse">
                    Gul'dan's Vault
                </h1>
                <p class="text-gray-300 text-lg font-medium">
                    <span class="text-purple-400">Forja tu</span> 
                    <span class="text-green-400">leyenda</span> 
                    <span class="text-red-400">gaming</span>
                </p>
                <p class="text-gray-500 text-sm mt-1">El poder de la biblioteca definitiva</p>
            </div>

            <!-- Register Card -->
            <div class="bg-black/40 backdrop-blur-xl rounded-2xl shadow-2xl border border-green-500/20 p-8 relative overflow-hidden">
                <!-- Mystical Border Effect -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-green-500/10 via-purple-500/10 to-red-500/10 animate-pulse"></div>
                
                <div class="relative z-10">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-white mb-2">Ritual de Iniciación</h2>
                        <p class="text-gray-400">Crea tu avatar del destino</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <x-input-label for="name" class="text-gray-200 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nombre del Campeón
                            </x-input-label>
                            <x-text-input id="name" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-blue-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:border-blue-400/50 focus:transform focus:scale-105" 
                                        type="text" 
                                        name="name" 
                                        :value="old('name')" 
                                        required 
                                        autofocus 
                                        autocomplete="name" 
                                        placeholder="Tu nombre épico" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <x-input-label for="email" class="text-gray-200 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Grimorio Élfico (Email)
                            </x-input-label>
                            <x-text-input id="email" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-green-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 hover:border-green-400/50 focus:transform focus:scale-105" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
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
                                Hechizo Protector
                            </x-input-label>
                            <x-text-input id="password" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-purple-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:border-purple-400/50 focus:transform focus:scale-105"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="new-password" 
                                        placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <x-input-label for="password_confirmation" class="text-gray-200 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Confirmar Poder
                            </x-input-label>
                            <x-text-input id="password_confirmation" 
                                        class="block w-full px-4 py-3 bg-black/30 border border-yellow-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 hover:border-yellow-400/50 focus:transform focus:scale-105"
                                        type="password"
                                        name="password_confirmation" 
                                        required 
                                        autocomplete="new-password" 
                                        placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Register Button -->
                        <div class="space-y-4 pt-2">
                            <x-primary-button class="w-full justify-center py-4 bg-gradient-to-r from-green-600 via-purple-600 to-red-600 hover:from-green-700 hover:via-purple-700 hover:to-red-700 text-white font-bold text-lg rounded-lg shadow-2xl transform hover:scale-105 transition-all duration-300 border border-green-500/30 hover:border-green-400/50 active:scale-95">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                                {{ __('Despertar Poder') }}
                            </x-primary-button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <span class="text-gray-400">¿Ya forjaste tu destino?</span>
                                <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-medium transition-colors duration-200 ml-1 hover:underline">
                                    Invocar sesión
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    © 2024 Gul'dan's Vault. 
                    <span class="text-purple-400">Where legends are born</span> 🎮
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Mystical animations */
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.3; 
            }
            25% { 
                transform: translateY(-20px) rotate(90deg); 
                opacity: 0.6; 
            }
            50% { 
                transform: translateY(-10px) rotate(180deg); 
                opacity: 0.4; 
            }
            75% { 
                transform: translateY(-15px) rotate(270deg); 
                opacity: 0.7; 
            }
        }

        @keyframes mystical-glow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.3); 
            }
            50% { 
                box-shadow: 0 0 30px rgba(147, 51, 234, 0.4), 0 0 40px rgba(239, 68, 68, 0.3); 
            }
        }
        
        /* Individual float animations with different timings */
        .animate-float-1 { animation: float 6s ease-in-out infinite; }
        .animate-float-2 { animation: float 8s ease-in-out infinite reverse; }
        .animate-float-3 { animation: float 7s ease-in-out infinite; }
        .animate-float-4 { animation: float 9s ease-in-out infinite; }
        .animate-float-5 { animation: float 5s ease-in-out infinite reverse; }
        .animate-float-6 { animation: float 10s ease-in-out infinite; }
        
        .animate-mystical-glow {
            animation: mystical-glow 3s ease-in-out infinite;
        }
        
        /* Enhanced focus effects */
        input:focus {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
        }
        
        /* Background transitions */
        #background-container {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Button press effect */
        button:active {
            transform: scale(0.95);
        }
    </style>

    <script>
        // Dynamic background loader using RAWG API
        document.addEventListener('DOMContentLoaded', function() {
            loadRandomGameBackground();
        });

        async function loadRandomGameBackground() {
            try {
                // Juegos épicos y oscuros para mejor ambientación
                const gameQueries = [
                    'world of warcraft', 'diablo', 'witcher 3', 'dark souls', 'elden ring',
                    'destiny 2', 'cyberpunk 2077', 'skyrim', 'bloodborne', 'god of war',
                    'hades', 'doom eternal', 'warhammer', 'hollow knight', 'sekiro'
                ];
                
                const randomQuery = gameQueries[Math.floor(Math.random() * gameQueries.length)];
                const apiKey = '{{ env("RAWG_API_KEY") }}'; // Asegúrate de tener tu API key en .env
                
                // Buscar juegos con screenshots
                const response = await fetch(`https://api.rawg.io/api/games?key=${apiKey}&search=${randomQuery}&page_size=10`);
                const data = await response.json();
                
                if (data.results && data.results.length > 0) {
                    // Seleccionar un juego aleatorio
                    const randomGame = data.results[Math.floor(Math.random() * data.results.length)];
                    
                    // Obtener screenshots del juego
                    const screenshotsResponse = await fetch(`https://api.rawg.io/api/games/${randomGame.id}/screenshots?key=${apiKey}`);
                    const screenshotsData = await screenshotsResponse.json();
                    
                    if (screenshotsData.results && screenshotsData.results.length > 0) {
                        const randomScreenshot = screenshotsData.results[Math.floor(Math.random() * screenshotsData.results.length)];
                        loadBackgroundImage(randomScreenshot.image);
                    } else if (randomGame.background_image) {
                        // Fallback a la imagen principal del juego
                        loadBackgroundImage(randomGame.background_image);
                    }
                }
            } catch (error) {
                console.log('Using fallback background - API request failed');
                // Mantener el gradiente por defecto
            }
        }

        function loadBackgroundImage(imageUrl) {
            const backgroundContainer = document.getElementById('background-container');
            const img = new Image();
            
            img.onload = function() {
                backgroundContainer.style.backgroundImage = `url('${imageUrl}')`;
                backgroundContainer.style.filter = 'brightness(0.3) contrast(1.2) saturate(1.1) blur(1px)';
                backgroundContainer.style.transform = 'scale(1.1)'; // Ligero zoom para efecto parallax
            };
            
            img.onerror = function() {
                console.log('Failed to load background image, using default');
            };
            
            img.src = imageUrl;
        }

        // Efectos adicionales al cargar la página
        window.addEventListener('load', function() {
            // Agregar clase de animación inicial
            document.body.classList.add('loaded');
            
            // Efecto de partículas aleatorias
            setTimeout(() => {
                createMysticalParticles();
            }, 2000);
        });

        function createMysticalParticles() {
            const particles = ['✨', '🌟', '💫', '⚡', '🔥'];
            
            setInterval(() => {
                if (Math.random() > 0.7) { // 30% de probabilidad
                    const particle = document.createElement('div');
                    particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                    particle.className = 'absolute text-2xl pointer-events-none animate-pulse';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.color = `hsl(${Math.random() * 360}, 70%, 60%)`;
                    particle.style.opacity = '0.4';
                    particle.style.zIndex = '5';
                    
                    document.body.appendChild(particle);
                    
                    // Remover partícula después de 3 segundos
                    setTimeout(() => {
                        if (particle.parentNode) {
                            particle.parentNode.removeChild(particle);
                        }
                    }, 3000);
                }
            }, 5000);
        }
    </script>
</x-guest-layout>