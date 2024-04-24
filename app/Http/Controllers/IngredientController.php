<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('order','asc')->get();
        return view('ingredients', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:ingredients,name',
            'cost' => 'required|numeric|min:0.01'
        ]);

        //Manually loading the ingredient to ensure order is last.
        try {
            $highestOrder = Ingredient::max('order');
            $order = $highestOrder + 1;

            $ingredient = new Ingredient();
            $ingredient->name = $request->name;
            $ingredient->cost = $request->cost;
            $ingredient->order = $order;
            $ingredient->save();

            return redirect()->route('ingredients')->with('success', 'Ingredient added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add ingredient: ' . $e->getMessage()]);
        }
    }



    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|max:255|unique:ingredients,name,' . $ingredient->id,
            'cost' => 'required|numeric|min:0.01'
        ]);

        $ingredient->update($request->all());
        return redirect()->route('ingredients')->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        // Check if the ingredient is used in any pizzas
        if ($ingredient->pizzas()->count() > 0) {
            return redirect()->route('ingredients')->with('error', 'Cannot delete ingredient because it is used in one or more pizzas.');
        }

        $ingredient->delete();
        return redirect()->route('ingredients')->with('success', 'Ingredient deleted successfully.');
    }

    //Order Ingredients up and down
    public function moveUp(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        // Find the previous ingredient
        $previousIngredient = Ingredient::where('order',  $ingredient->order-1)->first();

        if ($previousIngredient) {
            // Swap the order values
            $tempOrder = $ingredient->order;
            $ingredient->order = $previousIngredient->order;
            $previousIngredient->order = $tempOrder;

            // Save changes
            $ingredient->save();
            $previousIngredient->save();
        }

        return redirect()->back();
    }

    public function moveDown(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        // Find the next ingredient
        $nextIngredient = Ingredient::where('order', $ingredient->order+1)->first();

        if ($nextIngredient) {
            // Swap the order values
            $tempOrder = $ingredient->order;
            $ingredient->order = $nextIngredient->order;
            $nextIngredient->order = $tempOrder;

            // Save changes
            $ingredient->save();
            $nextIngredient->save();
        }

        return redirect()->back();
    }

}
