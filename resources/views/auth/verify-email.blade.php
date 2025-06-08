<x-guest-layout>
    <div class="min-h-screen relative overflow-hidden">
        <!-- Full Screen Dynamic Gaming Background -->
        <div id="bg-layer" class="fixed inset-0 transition-all duration-2000 ease-out">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-red-900 to-gray-900"></div>
            <div id="game-bg" class="absolute inset-0 opacity-0 transition-opacity duration-2000 bg-cover bg-center bg-fixed"></div>
        </div>
        
        <!-- Dark Overlay for better readability -->
        <div class="absolute inset-0 bg-black/60"></div>
        
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
                    <p class="text-gray-300 text-lg font-medium">Verificación de Email</p>
                </div>

                <!-- Verification Panel -->
                <div class="backdrop-blur-xl bg-gray-900/80 border border-red-500/30 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 space-y-6">
                        <div class="text-center text-gray-300">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="text-center text-green-400">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                            @csrf
                            <div class="text-center">
                                <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-red-500 via-orange-600 to-red-700 hover:from-red-600 hover:via-orange-700 hover:to-red-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                    <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-all duration-300"></div>
                                    <span class="relative">{{ __('Resend Verification Email') }}</span>
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="text-center">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300 underline">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
