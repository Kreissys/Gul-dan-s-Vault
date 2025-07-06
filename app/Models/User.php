<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'google_id',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            // Si es una URL de Google, devolverla directamente
            if (filter_var($this->profile_photo, FILTER_VALIDATE_URL)) {
                return $this->profile_photo;
            }
            // Si es un archivo local
            return asset('storage/profile-photos/' . $this->profile_photo);
        }
        return asset('images/default-profile.png'); // Imagen por defecto
    }

    /**
     * Verificar si el usuario se registró con Google
     */
    public function isGoogleUser()
    {
        return !is_null($this->google_id);
    }
}