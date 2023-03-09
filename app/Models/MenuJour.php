<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuJour extends Model
{
    use HasFactory;
    protected $fillable=[
        'jour_semaine',
        'articles'
    ];
    public function articles() :BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
