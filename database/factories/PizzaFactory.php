<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true), // Generates a random name
        ];
    }

    /**
     * Configure the factory to automatically attach random ingredients after creating a pizza.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Pizza $pizza) {
            // Attach random ingredients
            $ingredients = \App\Models\Ingredient::inRandomOrder()->take(rand(2, 5))->pluck('id');
            $pizza->ingredients()->sync($ingredients);
        });
    }
}
