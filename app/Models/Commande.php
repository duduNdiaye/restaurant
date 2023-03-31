<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomClient',
        'numeroClient',
        'coutTotal',
        'commentaire',
        'date',
        'heure',
        'adresse',
        'modeReception',
        'panier',
        'numeroCommande',
        'restaurantId',
        'email'
    ];
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
