<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_ingredient');
    }

    public function getSellingPriceAttribute()
    {
        $totalCost = $this->ingredients->sum('cost');
        return $totalCost * 1.5;  // Selling price includes 50% margin.
    }
}
