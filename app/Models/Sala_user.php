<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala_user extends Model
{
    use HasFactory;
    protected $table = 'sala_user';

    protected $fillable = [
        'user_id',
        'salas_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salas()
    {
        return $this->belongsTo(Sala::class);
    }
}

