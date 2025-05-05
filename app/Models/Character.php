<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Character.php
class Character extends Model
{
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    protected $fillable = [
        'name', 
        'image',
        'description'
    ];
}
