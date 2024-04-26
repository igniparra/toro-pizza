<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IngredientControllerTest extends TestCase
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
    public function admin_can_view_ingredients()
    {
        $this->actingAs($this->adminUser);
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients'));

        $response->assertStatus(200);
        $response->assertViewIs('ingredients');
        $response->assertViewHas('ingredients', function ($viewIngredients) use ($ingredient) {
            return $viewIngredients->contains($ingredient);
        });
    }

    #[Test]
    public function customer_cannot_view_ingredients()
    {
        $this->actingAs($this->customerUser);
        $response = $this->get(route('ingredients'));

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_store_ingredient()
    {
        $this->actingAs($this->adminUser);
        $response = $this->post(route('ingredients.store'), [
            'name' => 'New Ingredient',
            'cost' => 1.50
        ]);

        $response->assertRedirect(route('ingredients'));
        $response->assertSessionHas('success', 'Ingredient added successfully.');
        $this->assertDatabaseHas('ingredients', [
            'name' => 'New Ingredient',
            'cost' => 1.50
        ]);
    }

    #[Test]
    public function admin_can_update_ingredient()
    {
        $this->actingAs($this->adminUser);
        $ingredient = Ingredient::factory()->create();

        $response = $this->patch(route('ingredients.update', $ingredient), [
            'name' => 'Updated Name',
            'cost' => 2.00
        ]);

        $response->assertRedirect(route('ingredients'));
        $response->assertSessionHas('success', 'Ingredient updated successfully.');
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Updated Name',
            'cost' => 2.00
        ]);
    }

    #[Test]
    public function admin_can_delete_ingredient()
    {
        $this->actingAs($this->adminUser);
        $ingredient = Ingredient::factory()->create();

        $response = $this->delete(route('ingredients.destroy', $ingredient));

        $response->assertRedirect(route('ingredients'));
        $response->assertSessionHas('success', 'Ingredient deleted successfully.');
        $this->assertDatabaseMissing('ingredients', [
            'id' => $ingredient->id
        ]);
    }

    #[Test]
    public function admin_can_move_ingredient_up()
    {
        $this->actingAs($this->adminUser);
        $ingredient1 = Ingredient::factory()->create(['order' => 1]);
        $ingredient2 = Ingredient::factory()->create(['order' => 2]);

        $response = $this->post(route('ingredients.moveUp', ['ingredient' => $ingredient2->id]));

        $this->assertEquals(1, $ingredient2->fresh()->order);
        $this->assertEquals(2, $ingredient1->fresh()->order);
        $response->assertRedirect();
    }

    #[Test]
    public function admin_can_move_ingredient_down()
    {
        $this->actingAs($this->adminUser);
        $ingredient1 = Ingredient::factory()->create(['order' => 1]);
        $ingredient2 = Ingredient::factory()->create(['order' => 2]);

        $response = $this->post(route('ingredients.moveDown', ['ingredient' => $ingredient1->id]));

        $this->assertEquals(2, $ingredient1->fresh()->order);
        $this->assertEquals(1, $ingredient2->fresh()->order);
        $response->assertRedirect();
    }

    #[Test]
    public function customer_cannot_create_update_or_delete_ingredient()
    {
        $this->actingAs($this->customerUser);
        // Test create
        $responseCreate = $this->get(route('ingredients.create'));
        $responseCreate->assertStatus(403);

        // Test update
        $ingredient = Ingredient::factory()->create();
        $responseUpdate = $this->patch(route('ingredients.update', $ingredient), [
            'name' => 'Cannot Update',
            'cost' => 100
        ]);
        $responseUpdate->assertStatus(403);

        // Test delete
        $responseDelete = $this->delete(route('ingredients.destroy', $ingredient));
        $responseDelete->assertStatus(403);
    }
}
