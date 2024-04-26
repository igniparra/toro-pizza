<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        $ingredients = [
            ['name' => 'Tomato Sauce', 'cost' => 0.50],
            ['name' => 'Mozzarella Cheese', 'cost' => 0.75],
            ['name' => 'Pepperoni', 'cost' => 1.00],
            ['name' => 'Mushrooms', 'cost' => 0.55],
            ['name' => 'Onions', 'cost' => 0.30],
            ['name' => 'Black Olives', 'cost' => 0.40],
            ['name' => 'Green Peppers', 'cost' => 0.35],
            ['name' => 'Sausages', 'cost' => 1.20],
            ['name' => 'Bacon', 'cost' => 1.10],
            ['name' => 'Feta Cheese', 'cost' => 0.95],
            ['name' => 'Spinach', 'cost' => 0.65],
            ['name' => 'Pineapple', 'cost' => 0.85],
            ['name' => 'Ham', 'cost' => 0.90]
        ];

        $currentOrder = 1;  // Starting order number

        foreach ($ingredients as &$ingredient) {
            $ingredient['order'] = $currentOrder++;  // Assign current order and increment
        }

        DB::table('ingredients')->insert($ingredients);
    }
}
