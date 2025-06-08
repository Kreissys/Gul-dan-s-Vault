<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen relative overflow-hidden">
        <!-- Full Screen Dynamic Gaming Background -->
        <div id="bg-layer" class="fixed inset-0 transition-all duration-2000 ease-out">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-red-900 to-gray-900"></div>
            <div id="game-bg" class="absolute inset-0 opacity-0 transition-opacity duration-2000 bg-cover bg-center bg-fixed"></div>
        </div>
        
        <!-- Dark Overlay for better readability -->
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- Floating Gaming Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Demonic Hexagonal Grid -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-10" viewBox="0 0 100 100">
                <defs>
                    <pattern id="hex" patternUnits="userSpaceOnUse" width="10" height="8.66">
                        <polygon points="5,0 8.66,2.5 8.66,6.5 5,9 1.34,6.5 1.34,2.5" fill="none" stroke="#ff4444" stroke-width="0.2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hex)"/>
            </svg>
            
            <!-- Floating Particles -->
            <div id="particles-container" class="absolute inset-0"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-20 min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-lg">
                
                <!-- Header Section -->
                <div class="text-center mb-8 transform hover:scale-105 transition-all duration-500">
                    <div class="relative inline-block mb-6">
                        <!-- Glowing Skull/Demon Logo Container -->
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-500 via-orange-600 to-red-800 rounded-full p-1 shadow-2xl animate-pulse">
                            <div class="w-full h-full bg-gray-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.5 2 5.73 4.77 5.73 8.27c0 1.54.54 2.96 1.43 4.08L12 22l4.84-9.65c.89-1.12 1.43-2.54 1.43-4.08C18.27 4.77 15.5 2 12 2zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                                    <circle cx="12" cy="10" r="1"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Rotating Ring -->
                        <div class="absolute inset-0 border-2 border-red-400/30 rounded-full animate-spin" style="animation-duration: 8s;"></div>
                    </div>
                    
                    <h1 class="text-4xl font-black mb-2 bg-gradient-to-r from-red-400 via-orange-400 to-red-600 bg-clip-text text-transparent">
                        GUL'DAN VAULT
                    </h1>
                    <p class="text-gray-300 text-lg font-medium">Portal de Acceso</p>
                    <div id="game-info" class="text-sm text-gray-400 mt-2 opacity-0 transition-opacity duration-1000">
                        Cargando experiencia gaming...
                    </div>
                </div>

                <!-- Login Panel -->
                <div class="backdrop-blur-xl bg-gray-900/80 border border-red-500/30 rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Panel Header -->
                    <div class="bg-gradient-to-r from-red-500/10 via-orange-500/10 to-red-600/10 p-6 border-b border-gray-700/50">
                        <h2 class="text-xl font-bold text-white text-center">Iniciar Sesión</h2>
                        <p class="text-gray-400 text-center mt-1">Accede a tu biblioteca gaming</p>
                    </div>

                    <!-- Form -->
                    <div class="p-6 space-y-6">
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                    Email
                                </label>
                                <div class="relative">
                                    <input id="email" 
                                           name="email" 
                                           type="email" 
                                           :value="old('email')" 
                                           required 
                                           autofocus 
                                           autocomplete="username"
                                           placeholder="gamer@guldan.vault"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-red-500/0 via-orange-500/0 to-red-600/0 group-hover:from-red-500/5 group-hover:via-orange-500/5 group-hover:to-red-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Password Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Contraseña
                                </label>
                                <div class="relative">
                                    <input id="password" 
                                           name="password" 
                                           type="password" 
                                           required 
                                           autocomplete="current-password"
                                           placeholder="••••••••••"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-red-500/0 via-orange-500/0 to-red-600/0 group-hover:from-red-500/5 group-hover:via-orange-500/5 group-hover:to-red-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox" name="remember" class="w-4 h-4 text-red-500 bg-gray-800 border-gray-600 rounded focus:ring-red-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-400 group-hover:text-red-400 transition-colors">Recordarme</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-orange-400 hover:text-orange-300 transition-colors hover:underline">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-red-500 via-orange-600 to-red-700 hover:from-red-600 hover:via-orange-700 hover:to-red-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    ACCEDER AL VAULT
                                </div>
                            </button>

                            <!-- Register Link -->
                            @if (Route::has('register'))
                                <div class="text-center pt-4 border-t border-gray-700/50">
                                    <span class="text-gray-400">¿Nuevo jugador?</span>
                                    <a href="{{ route('register') }}" class="ml-2 text-red-400 hover:text-red-300 font-medium transition-colors hover:underline">
                                        Crear cuenta
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 space-y-2">
                    <div id="current-game" class="text-xs text-gray-500 opacity-0 transition-opacity duration-1000"></div>
                    <p class="text-gray-600 text-xs">
                        © 2024 Gul'dan Vault • Powered by ChefSoft
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.3); }
            50% { box-shadow: 0 0 40px rgba(234, 88, 12, 0.5), 0 0 60px rgba(239, 68, 68, 0.3); }
        }
        
        .animate-glow {
            animation: glow 3s ease-in-out infinite;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #ef4444, #f97316, #dc2626);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        #bg-layer {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        #game-bg {
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }
    </style>

    <script>
        // Configuration
        const RAWG_API_KEY = @json(config('services.rawg.api_key')) || 'demo-key';
        
        // Game categories with dark/fantasy themes for Gul'dan Vault
        const gameCategories = [
            { query: 'warcraft', theme: 'Warcraft Universe' },
            { query: 'diablo', theme: 'Dark Fantasy' },
            { query: 'dark souls', theme: 'Souls' },
            { query: 'witcher', theme: 'Dark Fantasy' },
            { query: 'skyrim', theme: 'Elder Scrolls' },
            { query: 'doom', theme: 'Demon Slaying' },
            { query: 'elden ring', theme: 'Dark Souls' },
            { query: 'mortal kombat', theme: 'Fighting' },
            { query: 'dragon age', theme: 'Fantasy RPG' },
            { query: 'baldurs gate', theme: 'D&D Fantasy' }
        ];
        
        let currentGameData = null;
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            loadRandomGamingBackground();
            
            // Change background every 25 seconds
            setInterval(loadRandomGamingBackground, 25000);
        });
        
        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles-container');
            
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
                container.appendChild(particle);
            }
        }
        
        // Load gaming background from RAWG API
        async function loadRandomGamingBackground() {
            try {
                const randomCategory = gameCategories[Math.floor(Math.random() * gameCategories.length)];
                updateGameInfo(`Explorando ${randomCategory.theme}...`);
                
                const response = await fetch(
                    `https://api.rawg.io/api/games?key=${RAWG_API_KEY}&search=${randomCategory.query}&page_size=20&ordering=-rating,-metacritic`
                );
                
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                
                const data = await response.json();
                const gamesWithBg = data.results.filter(game => 
                    game.background_image && 
                    game.rating > 3.5 &&
                    !game.background_image.includes('placeholder')
                );
                
                if (gamesWithBg.length > 0) {
                    const selectedGame = gamesWithBg[Math.floor(Math.random() * gamesWithBg.length)];
                    await setGameBackground(selectedGame);
                    updateGameInfo(`Experiencia: ${selectedGame.name} (${selectedGame.released || 'N/A'})`);
                    updateCurrentGame(`🎮 ${selectedGame.name} • ⭐ ${selectedGame.rating}/5 • 🏆 ${selectedGame.playtime}h promedio`);
                } else {
                    throw new Error('No suitable games found');
                }
                
            } catch (error) {
                console.log('Gaming API error:', error.message);
                updateGameInfo('Modo offline - Experiencia clásica');
                setFallbackBackground();
            }
        }
        
        // Set game background covering entire screen
        async function setGameBackground(game) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                const bgElement = document.getElementById('game-bg');
                
                img.onload = function() {
                    bgElement.style.backgroundImage = `url('${game.background_image}')`;
                    bgElement.style.backgroundSize = 'cover';
                    bgElement.style.backgroundPosition = 'center';
                    bgElement.style.backgroundAttachment = 'fixed';
                    bgElement.style.filter = 'brightness(0.3) contrast(1.2) saturate(1.3)';
                    
                    // Smooth transition
                    bgElement.style.opacity = '1';
                    
                    currentGameData = game;
                    resolve();
                };
                
                img.onerror = reject;
                img.src = game.background_image;
            });
        }
        
        // Fallback background
        function setFallbackBackground() {
            const bgElement = document.getElementById('game-bg');
            bgElement.style.background = 'linear-gradient(135deg, #7f1d1d 0%, #dc2626 50%, #991b1b 100%)';
            bgElement.style.opacity = '0.8';
        }
        
        // Update game info
        function updateGameInfo(text) {
            const infoElement = document.getElementById('game-info');
            infoElement.textContent = text;
            infoElement.style.opacity = '1';
        }
        
        // Update current game display
        function updateCurrentGame(text) {
            const currentGameElement = document.getElementById('current-game');
            if (currentGameElement) {
                currentGameElement.textContent = text;
                currentGameElement.style.opacity = '1';
            }
        }
        
        // Add smooth hover effects to form elements
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // Easter egg: Konami code
        let konamiCode = [];
        const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
        
        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            if (konamiCode.length > 10) konamiCode.shift();
            
            if (konamiCode.join(',') === konamiSequence.join(',')) {
                document.body.style.filter = 'hue-rotate(180deg) saturate(2)';
                setTimeout(() => {
                    document.body.style.filter = '';
                    alert('🔥 ¡Código Konami activado! ¡Por el poder de Gul\'dan! 🔥');
                }, 1000);
            }
        });
    </script>
</x-guest-layout>