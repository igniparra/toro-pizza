<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;

class CustomerController extends Controller
{
    public function customer()
    {
        // Retrieve all pizzas with their ingredients
        $pizzas = Pizza::with('ingredients')->get();
        $ingredients = Ingredient::orderBy('order','asc')->get();

        // Pass the pizzas and ingredients to the customer view
        return view('customer', compact('pizzas', 'ingredients'));
    }
}