<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the model that the factory corresponds to.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'cost' => $this->faker->randomFloat(2, 0.5, 10),  // Random cost between 0.5 and 10
            'order' => $this->faker->unique()->numberBetween(1, 100)  // Unique order for each ingredient
        ];
    }
}
