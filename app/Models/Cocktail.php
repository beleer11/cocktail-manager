<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;


    protected $fillable = [
        'cocktail_id',
        'name',
        'category',
        'alcoholic',
        'glass',
        'instructions',
        'thumbnail',
        'ingredients',
    ];


    protected $casts = [
        'ingredients' => 'array',
    ];
}