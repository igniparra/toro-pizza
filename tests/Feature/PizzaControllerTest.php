<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PizzaControllerTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;
    private $customerUser;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        // Create a customer user
        $this->customerUser = User::factory()->create(['role' => 'customer']);
    }

    #[Test]
    public function admin_can_view_pizzas()
    {
        $this->actingAs($this->adminUser);
        $pizza = Pizza::factory()->has(Ingredient::factory()->count(3))->create();

        $response = $this->get(route('pizzas'));

        $response->assertStatus(200);
        $response->assertViewIs('pizzas');
        $response->assertViewHas('pizzas');
    }

    #[Test]
    public function customer_cannot_view_pizzas()
    {
        $this->actingAs($this->customerUser);
        $response = $this->get(route('pizzas'));

        $response->assertStatus(403);
    }


    #[Test]
    public function admin_can_store_new_pizza()
    {
        $this->actingAs($this->adminUser);
        $ingredients = Ingredient::factory()->count(3)->create();
        $ingredientIds = $ingredients->pluck('id')->toArray();

        $response = $this->post(route('pizzas.store'), [
            'name' => 'Deluxe Pizza',
            'ingredients' => $ingredientIds
        ]);

        $response->assertRedirect(route('pizzas'));
        $response->assertSessionHas('success', 'Pizza created successfully.');
        $this->assertDatabaseHas('pizzas', ['name' => 'Deluxe Pizza']);
    }


    #[Test]
    public function admin_can_update_pizza()
    {
        $this->actingAs($this->adminUser);
        $pizza = Pizza::factory()->create();
        $ingredients = Ingredient::factory()->count(2)->create();
        $ingredientIds = $ingredients->pluck('id')->toArray();

        $response = $this->patch(route('pizzas.update', $pizza), [
            'name' => 'Updated Pizza',
            'ingredients' => $ingredientIds
        ]);

        $response->assertRedirect(route('pizzas'));
        $response->assertSessionHas('success', 'Pizza updated successfully.');
        $this->assertDatabaseHas('pizzas', ['name' => 'Updated Pizza']);
    }

    #[Test]
    public function admin_can_delete_pizza()
    {
        $this->actingAs($this->adminUser);
        $pizza = Pizza::factory()->create();

        $response = $this->delete(route('pizzas.destroy', $pizza));

        $response->assertRedirect(route('pizzas'));
        $response->assertSessionHas('success', 'Pizza deleted successfully.');
        $this->assertDatabaseMissing('pizzas', ['id' => $pizza->id]);
    }
}
