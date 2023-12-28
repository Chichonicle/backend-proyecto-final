<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    public function salas(): HasOne
    {
        return $this->hasOne(Sala::class);
    }
    
}
