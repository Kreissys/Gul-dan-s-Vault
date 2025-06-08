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
            <!-- Recovery Hexagonal Grid -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-10" viewBox="0 0 100 100">
                <defs>
                    <pattern id="recovery-hex" patternUnits="userSpaceOnUse" width="10" height="8.66">
                        <polygon points="5,0 8.66,2.5 8.66,6.5 5,9 1.34,6.5 1.34,2.5" fill="none" stroke="#8b5cf6" stroke-width="0.2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#recovery-hex)"/>
            </svg>
            
            <!-- Floating Recovery Particles -->
            <div id="particles-container" class="absolute inset-0"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-20 min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-lg">
                
                <!-- Header Section -->
                <div class="text-center mb-8 transform hover:scale-105 transition-all duration-500">
                    <div class="relative inline-block mb-6">
                        <!-- Recovery Key Logo -->
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-500 via-violet-600 to-purple-800 rounded-full p-1 shadow-2xl animate-pulse">
                            <div class="w-full h-full bg-gray-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7,14A3,3 0 0,1 10,17A3,3 0 0,1 7,20A3,3 0 0,1 4,17A3,3 0 0,1 7,14M7,16A1,1 0 0,0 6,17A1,1 0 0,0 7,18A1,1 0 0,0 8,17A1,1 0 0,0 7,16M20.05,4.95L15.54,9.46L16.95,10.87L21.46,6.36L20.05,4.95M8.81,3.5L7.39,4.91L10.59,8.11L12,6.7L8.81,3.5M12.7,12L11.29,10.59L2.81,19.07L1.39,17.66L9.87,9.18L8.46,7.77L-0.02,16.25L4.95,21.22L13.43,12.74L12.02,11.33L12.7,12Z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Rotating Recovery Ring -->
                        <div class="absolute inset-0 border-2 border-purple-400/30 rounded-full animate-spin" style="animation-duration: 8s;"></div>
                    </div>
                    
                    <h1 class="text-4xl font-black mb-2 bg-gradient-to-r from-purple-400 via-violet-400 to-purple-600 bg-clip-text text-transparent">
                        RECUPERACIÓN
                    </h1>
                    <p class="text-gray-300 text-lg font-medium">Centro de Restauración</p>
                    <div id="game-info" class="text-sm text-gray-400 mt-2 opacity-0 transition-opacity duration-1000">
                        Cargando experiencia gaming...
                    </div>
                </div>

                <!-- Recovery Panel -->
                <div class="backdrop-blur-xl bg-gray-900/80 border border-purple-500/30 rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Panel Header -->
                    <div class="bg-gradient-to-r from-purple-500/10 via-violet-500/10 to-purple-600/10 p-6 border-b border-gray-700/50">
                        <h2 class="text-xl font-bold text-white text-center">Recuperar Contraseña</h2>
                        <p class="text-gray-400 text-center mt-3 leading-relaxed">
                            ¿Olvidaste tu contraseña? No hay problema. Solo déjanos saber tu dirección de email 
                            y te enviaremos un enlace de restablecimiento que te permitirá elegir una nueva.
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Form -->
                    <div class="p-6 space-y-6">
                        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                            @csrf

                            <!-- Email Field -->
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                    Email de Recuperación
                                </label>
                                <div class="relative">
                                    <input id="email" 
                                           name="email" 
                                           type="email" 
                                           :value="old('email')" 
                                           required 
                                           autofocus 
                                           placeholder="gamer@guldan.vault"
                                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 group-hover:border-gray-500">
                                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-purple-500/0 via-violet-500/0 to-purple-600/0 group-hover:from-purple-500/5 group-hover:via-violet-500/5 group-hover:to-purple-600/5 transition-all duration-300 pointer-events-none"></div>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                            </div>

                            <!-- Send Recovery Button -->
                            <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-purple-500 via-violet-600 to-purple-700 hover:from-purple-600 hover:via-violet-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    ENVIAR ENLACE DE RECUPERACIÓN
                                </div>
                            </button>

                            <!-- Back to Login -->
                            <div class="text-center pt-4 border-t border-gray-700/50">
                                <span class="text-gray-400">¿Recordaste tu contraseña?</span>
                                <a href="{{ route('login') }}" class="ml-2 text-purple-400 hover:text-purple-300 font-medium transition-colors hover:underline">
                                    Volver al Login
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
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #8b5cf6, #7c3aed, #a855f7);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
    </style>

    <script>
        const RAWG_API_KEY = @json(config('services.rawg.api_key')) || 'demo-key';
        
        const recoveryGameCategories = [
            { query: 'amnesia', theme: 'Memory Recovery' },
            { query: 'puzzle', theme: 'Mind Games' },
            { query: 'mystery', theme: 'Mystery Solving' },
            { query: 'adventure', theme: 'Epic Adventures' },
            { query: 'portal', theme: 'Portal Series' },
            { query: 'the witness', theme: 'Brain Teasers' }
        ];
        
        document.addEventListener('DOMContentLoaded', function() {
            createRecoveryParticles();
            loadRecoveryGamingBackground();
            setInterval(loadRecoveryGamingBackground, 25000);
        });
        
        function createRecoveryParticles() {
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
        
        async function loadRecoveryGamingBackground() {
            try {
                const randomCategory = recoveryGameCategories[Math.floor(Math.random() * recoveryGameCategories.length)];
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
                    updateCurrentGame(`🔍 ${selectedGame.name} • ⭐ ${selectedGame.rating}/5 • 🧩 Modo Recuperación`);
                }
                
            } catch (error) {
                console.log('Gaming API error:', error.message);
                updateGameInfo('Modo offline - Sistema de recuperación');
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
            bgElement.style.background = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #a855f7 100%)';
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