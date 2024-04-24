<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
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

        session()->flash('Success','Ingredient added successfully');
        
        Ingredient::create($request->all());
        return redirect()->route('ingredients')->with('success', 'Ingredient added successfully.');
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

}
