<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('order');
    }

    public function getSellingPrice()
    {
        $totalCost = $this->ingredients->sum('cost');
        return $totalCost * 1.5;  //Selling price includes 50% margin.
    }
}

