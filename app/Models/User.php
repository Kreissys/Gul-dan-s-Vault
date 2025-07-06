<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable; // Usa el User especial de MongoDB
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $connection = 'mongodb'; // Muy importante para usar la conexión MongoDB
    protected $collection = 'users';   // opcional, si tu colección se llama diferente

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo'
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
            return asset('storage/profile-photos/' . $this->profile_photo);
        }
        return asset('images/default-profile.png'); // Imagen por defecto
    }
}
