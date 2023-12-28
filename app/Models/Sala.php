<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie_id');
    }
}
