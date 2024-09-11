<?php

namespace Arneon\LaravelPizzas\Infrastructure\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'ingredients';
    protected $fillable = [
        'name',
        'price',
    ];
    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'pizza_ingredients', 'ingredient_id', 'pizza_id');
    }
}

