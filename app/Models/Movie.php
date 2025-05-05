<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Movie.php
class Movie extends Model
{
    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }

    protected $fillable = [
        'name', 
        'classification',
        'release_date',
        'review',
        'type',
        'season'
    ];
}