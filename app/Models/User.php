<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }
    
    public function sala_user()
    {
        return $this->hasMany(Sala_user::class);
    }
    public function salas()
    {
        return $this->belongsToMany(Sala::class, 'sala_user', 'user_id', 'salas_id');
    }
    public function messageToRoom(): BelongsToMany
    {
        return $this->belongsToMany(Sala::class, 'messages');
    }
    public function messages()
    {
        return $this->hasMany(Mensaje::class);
    }
    
    
}
