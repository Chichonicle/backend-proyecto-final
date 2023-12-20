<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capitulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'serie_id',
    ];

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }
}
