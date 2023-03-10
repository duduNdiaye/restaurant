<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Article extends Model
{
    use HasFactory;
    protected $guarded=[
        'id',
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function commandes() :BelongsToMany
    {
        return $this->belongsToMany(Commande::class);
    }
    public function menujours():BelongsToMany
    {
        return $this->belongsToMany(MenuJour::class);
    }
}
