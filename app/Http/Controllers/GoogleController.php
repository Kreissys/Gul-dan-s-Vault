<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario existente por email
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // Usuario existe, actualizar datos de Google si es necesario
                $user->update([
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'profile_photo' => $googleUser->avatar ?? $user->profile_photo,
                ]);
                Auth::login($user);
            } else {
                // Crear nuevo usuario
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => \Hash::make(Str::random(16)),
                    'role' => 'user',
                    'google_id' => $googleUser->id,
                    'profile_photo' => $googleUser->avatar,
                ]);
                Auth::login($newUser);
            }

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Error al iniciar sesión con Google');
        }
    }
}
