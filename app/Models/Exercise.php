<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    // AJOUTE CE BLOC POUR AUTORISER LA MODIFICATION DES DONNÉES
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'order',
        'duration_inhale',
        'duration_hold',
        'duration_exhale',
    ];
}