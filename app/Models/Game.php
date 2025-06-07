<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'games';

    protected $fillable = [
        'user_id',
        'rawg_id',
        'rawg_slug',
        'title',
        'image',
        'release_date',
        'genres',
        'platforms',
        'status',
        'rating',
        'hours_played',
        'notes',
        'metacritic_score',
        'playtime',
    ];

    protected $casts = [
        'genres' => 'array',
        'platforms' => 'array',
        'hours_played' => 'decimal:1',
        'rating' => 'integer',
        'rawg_id' => 'integer',
        'metacritic_score' => 'integer',
        'playtime' => 'integer',
        'release_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pendiente' => 'bg-gray-500',
            'jugando' => 'bg-blue-500',
            'completado' => 'bg-green-500',
            'abandonado' => 'bg-red-500',
            default => 'bg-gray-500'
        };
    }

    /**
     * Obtener el texto del estado en español
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pendiente' => 'Pendiente',
            'jugando' => 'Jugando',
            'completado' => 'Completado',
            'abandonado' => 'Abandonado',
            default => 'Sin estado'
        };
    }

    /**
     * Obtener géneros como string
     */
    public function getGenresStringAttribute()
    {
        return is_array($this->genres) ? implode(', ', $this->genres) : '';
    }

    /**
     * Obtener plataformas como string
     */
    public function getPlatformsStringAttribute()
    {
        return is_array($this->platforms) ? implode(', ', $this->platforms) : '';
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}