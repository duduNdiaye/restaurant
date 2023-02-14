<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomClient',
        'numeroClient',
        'commentaire',
        'dateHeure',
        'dateHeure',
        'modeReception',
        'panier',
    ];
}
