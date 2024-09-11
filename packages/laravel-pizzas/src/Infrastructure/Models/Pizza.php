<?php

namespace Arneon\LaravelPizzas\Infrastructure\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;
    protected $table = 'pizzas';
    protected $fillable = [
        'name',
        'image',
        'description',
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_ingredients', 'pizza_id', 'ingredient_id');
    }
}

