<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "salas_id"
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

