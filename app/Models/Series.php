<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Series extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'genre',
        'year',
        'url',
        'is_active',
        'picture',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function serie(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }
    public function salas(): HasMany
    {
        return $this->hasMany(Sala::class);
    }
    public function mensajes(): HasMany
    {
        return $this->hasMany(Mensaje::class);
    }
}
