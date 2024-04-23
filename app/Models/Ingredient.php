<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'cost'];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class)->withPivot('order');
    }
}

