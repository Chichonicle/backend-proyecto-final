<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genre',
        'year',
        'url',
        'picture',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function series(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
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
