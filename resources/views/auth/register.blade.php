<x-guest-layout>
    <div class="min-h-screen relative overflow-hidden">
        <!-- Full Screen Dynamic Gaming Background -->
        <div id="bg-layer" class="fixed inset-0 transition-all duration-2000 ease-out">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-purple-900 to-gray-900"></div>
            <div id="game-bg" class="absolute inset-0 opacity-0 transition-opacity duration-2000 bg-cover bg-center bg-fixed"></div>
        </div>
        
        <!-- Dark Overlay for better readability -->
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- Floating Gaming Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Mystical Hexagonal Grid -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-10" viewBox="0 0 100 100">
                <defs>
                    <pattern id="hex-register" patternUnits="userSpaceOnUse" width="10" height="8.66">
                        <polygon points="5,0 8.66,2.5 8.66,6.5 5,9 1.34,6.5 1.34,2.5" fill="none" stroke="#8b5cf6" stroke-width="0.2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hex-register)"/>
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
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-500 via-blue-600 to-purple-800 rounded-full p-1 shadow-2xl animate-pulse">
                            <div class="w-full h-full bg-gray-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1s1-.45 1-1v-1.26c.64.16 1.31.26 2 .26s1.36-.1 2-.26V17c0 .55.45 1 1 1s1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zM9 9c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                                    <path d="M12 12c-1.1 0-2 .9-2 2v2h4v-2c0-1.1-.9-2-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Rotating Ring -->
                        <div class="absolute inset-0 border-2 border-purple-400/30 rounded-full animate-spin" style="animation-duration: 8s;"></div>
                    </div>
                    
                    <h1 class="text-4xl font-black mb-2 bg-gradient-to-r from-purple-400 via-blue-400 to-purple-600 bg-clip-text text-transparent">
                        GUL'DAN VAULT
                    </h1>
                    <p class="text-gray-300 text-lg font-medium">Ritual de Iniciación</p>
                    <div id="game-info" class="text-sm text-gray-400 mt-2 opacity-0 transition-opacity duration-1000">
                        Explorando universos gaming...
                    </div>
                </div>

                <!-- Register Panel -->
                <div class="backdrop-blur-xl bg-gray-900/80 border border-purple-500/30 rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Panel Header -->
                    <div class="bg-gradient-to-r from-purple-500/10 via-blue-500/10 to-purple-600/10 p-6 border-b border-gray-700/50">
                        <h2 class="text-xl font-bold text-white text-center">Crear Nueva Cuenta</h2>
                        <p class="text-gray-400 text-center mt-1">Forja tu leyenda gaming</p>
                    </div>

                    <!-- Form -->
                    <div class="p-6 space-y-6">
                        <form method="POST" action="{{ route('register') }}" class="space-y-5">
                            @csrf

                            <!-- Name Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Nombre del Campeón
                                </label>
                                <div class="relative">
                                    <input id="name" 
                                           name="name" 
                                           type="text" 
                                           :value="old('name')" 
                                           required 
                                           autofocus 
                                           autocomplete="name"
                                           placeholder="Tu nombre épico"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-500/0 via-purple-500/0 to-blue-600/0 group-hover:from-blue-500/5 group-hover:via-purple-500/5 group-hover:to-blue-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Email Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Grimorio Élfico (Email)
                                </label>
                                <div class="relative">
                                    <input id="email" 
                                           name="email" 
                                           type="email" 
                                           :value="old('email')" 
                                           required 
                                           autocomplete="username"
                                           placeholder="warlock@azeroth.com"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-green-500/0 via-blue-500/0 to-green-600/0 group-hover:from-green-500/5 group-hover:via-blue-500/5 group-hover:to-green-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Password Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Hechizo Protector
                                </label>
                                <div class="relative">
                                    <input id="password" 
                                           name="password" 
                                           type="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="••••••••••"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-purple-500/0 via-pink-500/0 to-purple-600/0 group-hover:from-purple-500/5 group-hover:via-pink-500/5 group-hover:to-purple-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Confirmar Poder
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" 
                                           name="password_confirmation" 
                                           type="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="••••••••••"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-yellow-500/0 via-orange-500/0 to-yellow-600/0 group-hover:from-yellow-500/5 group-hover:via-orange-500/5 group-hover:to-yellow-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-purple-500 via-blue-600 to-purple-700 hover:from-purple-600 hover:via-blue-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                    </svg>
                                    DESPERTAR PODER
                                </div>
                            </button>

                            <!-- Mensaje sobre Google -->
                            <div class="text-center text-gray-400 mt-4">
                                <p>¿O prefieres forjar tu leyenda con Google?</p>
                            </div>

                            <!-- Google Register Button -->
                            <div class="mt-4">
                                <a href="{{ route('google.redirect') }}" class="w-full group relative overflow-hidden bg-gradient-to-r from-purple-500 via-blue-600 to-purple-700 hover:from-purple-600 hover:via-blue-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                    <div class="relative flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        </svg>
                                        FORJAR CON GOOGLE
                                    </div>
                                </a>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center pt-4 border-t border-gray-700/50">
                                <span class="text-gray-400">¿Ya forjaste tu destino?</span>
                                <a href="{{ route('login') }}" class="ml-2 text-purple-400 hover:text-purple-300 font-medium transition-colors hover:underline">
                                    Invocar sesión
                                </a>
                            </div>
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
            0%, 100% { box-shadow: 0 0 20px rgba(147, 51, 234, 0.3); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.5), 0 0 60px rgba(147, 51, 234, 0.3); }
        }
        
        .animate-glow {
            animation: glow 3s ease-in-out infinite;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #8b5cf6, #3b82f6, #6366f1);
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
        
        // Game categories with fantasy/epic themes for registration
        const gameCategories = [
            { query: 'elder scrolls', theme: 'Elder Scrolls Universe' },
            { query: 'final fantasy', theme: 'Final Fantasy' },
            { query: 'world of warcraft', theme: 'Warcraft' },
            { query: 'dragon age', theme: 'Dragon Age' },
            { query: 'mass effect', theme: 'Mass Effect' },
            { query: 'witcher', theme: 'The Witcher' },
            { query: 'cyberpunk', theme: 'Cyberpunk' },
            { query: 'assassins creed', theme: 'Assassin\'s Creed' },
            { query: 'destiny', theme: 'Destiny' },
            { query: 'halo', theme: 'Halo Universe' }
        ];
        
        let currentGameData = null;
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            loadRandomGamingBackground();
            
            // Change background every 30 seconds
            setInterval(loadRandomGamingBackground, 30000);
        });
        
        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles-container');
            
            for (let i = 0; i < 20; i++) {
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
                    game.rating > 4.0 &&
                    !game.background_image.includes('placeholder')
                );
                
                if (gamesWithBg.length > 0) {
                    const selectedGame = gamesWithBg[Math.floor(Math.random() * gamesWithBg.length)];
                    await setGameBackground(selectedGame);
                    updateGameInfo(`Universo: ${selectedGame.name} (${selectedGame.released || 'N/A'})`);
                    updateCurrentGame(`🎮 ${selectedGame.name} • ⭐ ${selectedGame.rating}/5 • 🏆 ${selectedGame.playtime}h épicas`);
                } else {
                    throw new Error('No suitable games found');
                }
                
            } catch (error) {
                console.log('Gaming API error:', error.message);
                updateGameInfo('Modo místico - Experiencia épica');
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
                    bgElement.style.filter = 'brightness(0.25) contrast(1.3) saturate(1.4) hue-rotate(15deg)';
                    
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
            bgElement.style.background = 'linear-gradient(135deg, #581c87 0%, #7c3aed 50%, #5b21b6 100%)';
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
        
        // Password strength indicator (opcional)
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        passwordInput.addEventListener('input', function() {
            const strength = getPasswordStrength(this.value);
            // Opcional: agregar indicador visual de fuerza de contraseña
        });
        
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#22c55e';
            }
        });
        
        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
        
        // Easter egg: Konami code for registration
        let konamiCode = [];
        const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
        
        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            if (konamiCode.length > 10) konamiCode.shift();
            
            if (konamiCode.join(',') === konamiSequence.join(',')) {
                document.body.style.filter = 'hue-rotate(120deg) saturate(2)';
                setTimeout(() => {
                    document.body.style.filter = '';
                    alert('🔥 ¡Código épico activado! ¡El poder de Azeroth te acompaña! 🔥');
                }, 1000);
            }
        });
        
        // Mystical particles effect
        function createMysticalParticles() {
            const particles = ['✨', '🌟', '💫', '⚡', '🔮'];
            
            setInterval(() => {
                if (Math.random() > 0.8) { // 20% de probabilidad
                    const particle = document.createElement('div');
                    particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                    particle.className = 'absolute text-xl pointer-events-none animate-pulse';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.color = `hsl(${Math.random() * 360}, 70%, 60%)`;
                    particle.style.opacity = '0.6';
                    particle.style.zIndex = '5';
                    particle.style.animation = 'float 4s ease-in-out forwards';
                    
                    document.body.appendChild(particle);
                    
                    // Remover partícula después de 4 segundos
                    setTimeout(() => {
                        if (particle.parentNode) {
                            particle.parentNode.removeChild(particle);
                        }
                    }, 4000);
                }
            }, 6000);
        }
        
        // Initialize mystical effects
        setTimeout(createMysticalParticles, 3000);
    </script>
</x-guest-layout>