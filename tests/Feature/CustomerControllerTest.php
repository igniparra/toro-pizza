<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_pizzas_and_ingredients()
    {
        // Arrange: Create some pizzas, ingredients, and a user
        $pizzas = Pizza::factory()->count(3)->create();
        $ingredients = Ingredient::factory()->count(5)->create();
        $user = User::factory()->create();  // Assuming you have a user factory

        // Act: Authenticate the user and visit the customer page
        $response = $this->actingAs($user)->get(route('customer'));

        // Assert: Check correct view is returned with the right data
        $response->assertStatus(200);
        $response->assertViewIs('customer');
        $response->assertViewHas('pizzas', function ($viewPizzas) use ($pizzas) {
            return $viewPizzas->count() === 3; // Check if 3 pizzas are passed to the view
        });
        $response->assertViewHas('ingredients', function ($viewIngredients) use ($ingredients) {
            return $viewIngredients->count() === 5; // Check if 5 ingredients are passed to the view
        });
    }
}
