<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzasTableSeeder extends Seeder
{
    public function run()
    {
        $pizzas = [
            [
                'name' => 'Classic Margherita',
                'selling_price' => 7.50,
                'ingredients' => [
                    ['name' => 'Tomato Sauce', 'order' => 1],
                    ['name' => 'Mozzarella Cheese', 'order' => 2]
                ]
            ],
            [
                'name' => 'Pepperoni Pizza',
                'selling_price' => 8.25,
                'ingredients' => [
                    ['name' => 'Tomato Sauce', 'order' => 1],
                    ['name' => 'Mozzarella Cheese', 'order' => 2],
                    ['name' => 'Pepperoni', 'order' => 3]
                ]
            ],
            [
                'name' => 'Vegetarian Pizza',
                'selling_price' => 9.00,
                'ingredients' => [
                    ['name' => 'Tomato Sauce', 'order' => 1],
                    ['name' => 'Mozzarella Cheese', 'order' => 2],
                    ['name' => 'Mushrooms', 'order' => 3],
                    ['name' => 'Onions', 'order' => 4],
                    ['name' => 'Green Peppers', 'order' => 5],
                    ['name' => 'Black Olives', 'order' => 6]
                ]
            ]
        ];

        foreach ($pizzas as $pizza) {
            $pizzaId = DB::table('pizzas')->insertGetId([
                'name' => $pizza['name'],
            ]);

            foreach ($pizza['ingredients'] as $ingredient) {
                $ingredientRecord = DB::table('ingredients')
                    ->where('name', $ingredient['name'])
                    ->first();

                if ($ingredientRecord) {
                    DB::table('pizza_ingredient')->insert([
                        'pizza_id' => $pizzaId,
                        'ingredient_id' => $ingredientRecord->id,
                        'order' => $ingredient['order']
                    ]);
                } else {
                    // Log or handle the case where ingredient does not exist
                    echo 'Ingredient not found: ' . $ingredient['name'] . "\n";
                }
            }
        }
    }
}
