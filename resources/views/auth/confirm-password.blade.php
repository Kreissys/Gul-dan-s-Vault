<x-guest-layout>
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
            <!-- Security Hexagonal Grid -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-10" viewBox="0 0 100 100">
                <defs>
                    <pattern id="security-hex" patternUnits="userSpaceOnUse" width="10" height="8.66">
                        <polygon points="5,0 8.66,2.5 8.66,6.5 5,9 1.34,6.5 1.34,2.5" fill="none" stroke="#f97316" stroke-width="0.2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#security-hex)"/>
            </svg>
            
            <!-- Floating Security Particles -->
            <div id="particles-container" class="absolute inset-0"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-20 min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-lg">
                
                <!-- Header Section -->
                <div class="text-center mb-8 transform hover:scale-105 transition-all duration-500">
                    <div class="relative inline-block mb-6">
                        <!-- Security Shield Logo -->
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-orange-500 via-red-600 to-orange-800 rounded-full p-1 shadow-2xl animate-pulse">
                            <div class="w-full h-full bg-gray-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11H16V16H8V11H9.2V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.4,8.7 10.4,10V11H13.6V10C13.6,8.7 12.8,8.2 12,8.2Z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Rotating Security Ring -->
                        <div class="absolute inset-0 border-2 border-orange-400/30 rounded-full animate-spin" style="animation-duration: 8s;"></div>
                    </div>
                    
                    <h1 class="text-4xl font-black mb-2 bg-gradient-to-r from-orange-400 via-red-400 to-orange-600 bg-clip-text text-transparent">
                        ZONA SEGURA
                    </h1>
                    <p class="text-gray-300 text-lg font-medium">Verificación de Seguridad</p>
                    <div id="game-info" class="text-sm text-gray-400 mt-2 opacity-0 transition-opacity duration-1000">
                        Cargando experiencia gaming...
                    </div>
                </div>

                <!-- Security Panel -->
                <div class="backdrop-blur-xl bg-gray-900/80 border border-orange-500/30 rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Panel Header -->
                    <div class="bg-gradient-to-r from-orange-500/10 via-red-500/10 to-orange-600/10 p-6 border-b border-gray-700/50">
                        <h2 class="text-xl font-bold text-white text-center">Confirmación de Contraseña</h2>
                        <p class="text-gray-400 text-center mt-3 leading-relaxed">
                            Esta es un área segura de la aplicación. Por favor confirma tu contraseña antes de continuar.
                        </p>
                    </div>

                    <!-- Form -->
                    <div class="p-6 space-y-6">
                        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                            @csrf

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
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-orange-500/0 via-red-500/0 to-orange-600/0 group-hover:from-orange-500/5 group-hover:via-red-500/5 group-hover:to-orange-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Confirm Button -->
                            <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-orange-500 via-red-600 to-orange-700 hover:from-orange-600 hover:via-red-700 hover:to-orange-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    CONFIRMAR ACCESO
                                </div>
                            </button>
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
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #f97316, #dc2626, #ea580c);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
    </style>

    <script>
        const RAWG_API_KEY = @json(config('services.rawg.api_key')) || 'demo-key';
        
        const securityGameCategories = [
            { query: 'cyberpunk', theme: 'Cybersecurity' },
            { query: 'hacking', theme: 'Hacker Games' },
            { query: 'stealth', theme: 'Stealth Operations' },
            { query: 'watchdogs', theme: 'Digital Security' },
            { query: 'metal gear', theme: 'Tactical Espionage' },
            { query: 'deus ex', theme: 'Cyber Thriller' }
        ];
        
        document.addEventListener('DOMContentLoaded', function() {
            createSecurityParticles();
            loadSecurityGamingBackground();
            setInterval(loadSecurityGamingBackground, 25000);
        });
        
        function createSecurityParticles() {
            const container = document.getElementById('particles-container');
            for (let i = 0; i < 12; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
                container.appendChild(particle);
            }
        }
        
        async function loadSecurityGamingBackground() {
            try {
                const randomCategory = securityGameCategories[Math.floor(Math.random() * securityGameCategories.length)];
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
                    setGameBackground(selectedGame);
                    updateGameInfo(`Experiencia: ${selectedGame.name} (${selectedGame.released || 'N/A'})`);
                    updateCurrentGame(`🔒 ${selectedGame.name} • ⭐ ${selectedGame.rating}/5 • 🎮 Modo Seguro`);
                }
                
            } catch (error) {
                console.log('Gaming API error:', error.message);
                updateGameInfo('Modo offline - Seguridad activada');
                setFallbackBackground();
            }
        }
        
        function setGameBackground(game) {
            const bgElement = document.getElementById('game-bg');
            bgElement.style.backgroundImage = `url('${game.background_image}')`;
            bgElement.style.backgroundSize = 'cover';
            bgElement.style.backgroundPosition = 'center';
            bgElement.style.backgroundAttachment = 'fixed';
            bgElement.style.filter = 'brightness(0.3) contrast(1.2) saturate(1.3)';
            bgElement.style.opacity = '1';
        }
        
        function setFallbackBackground() {
            const bgElement = document.getElementById('game-bg');
            bgElement.style.background = 'linear-gradient(135deg, #ea580c 0%, #dc2626 50%, #c2410c 100%)';
            bgElement.style.opacity = '0.8';
        }
        
        function updateGameInfo(text) {
            document.getElementById('game-info').textContent = text;
            document.getElementById('game-info').style.opacity = '1';
        }
        
        function updateCurrentGame(text) {
            const element = document.getElementById('current-game');
            if (element) {
                element.textContent = text;
                element.style.opacity = '1';
            }
        }
    </script>
</x-guest-layout>