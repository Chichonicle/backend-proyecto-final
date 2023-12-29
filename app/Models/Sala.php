<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'series_id',
        'created_at',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }
    public function sala_user()
    {
        return $this->hasMany(User::class);
    }
    public function messageToUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'messages');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'sala_user', 'salas_id', 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Mensaje::class);
    }
}
