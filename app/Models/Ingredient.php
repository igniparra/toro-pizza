<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cost'];

    //Defining a Boot method so that new ingredients have the highest order (go to bottom)
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ingredient) {
            // Get the new highest order.
            $highestOrder = Ingredient::max('order');
            $ingredient->order = $highestOrder ? $highestOrder + 1 : 1;
        });
    }

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'pizza_ingredient')->withPivot('order');
    }
}

