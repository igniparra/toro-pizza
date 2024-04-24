<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use DB;

class PizzaController extends Controller
{
    // Display a listing of pizzas
    public function index()
    {
        $pizzas = Pizza::with('ingredients')->get();
        $ingredients = Ingredient::all();
        return view('pizzas', compact('pizzas','ingredients'));
    }

    // Show the form for creating a new pizza
    public function create()
    {
        return view('pizzas.create');
    }

    // Store a newly created pizza in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array', 
            'ingredients.*' => 'exists:ingredients,id' // Validate each ingredient ID exists
        ]);

        //The following is done to mantain db integrity
        DB::beginTransaction();
        try {
            // Create the pizza with name and description
            $pizza = Pizza::create([
                'name' => $request->name,
            ]);

            // Sync the ingredients to the pivot table
            $pizza->ingredients()->sync($request->ingredients);

            // Commit the transaction
            DB::commit();
            return redirect()->route('pizzas')->with('success', 'Pizza created successfully.');
        } catch (\Exception $e) {
            // An error occurred; cancel the transaction...
            DB::rollback();
            // and return to the previous page with an error
            return redirect()->route('pizzas')->with('error', 'Error creating pizza: ' . $e->getMessage());
        }
    }


    // Show the form for editing the specified pizza
    public function edit(Pizza $pizza)
    {
        return view('pizzas.edit', compact('pizza'));
    }

    // Update the specified pizza in storage
    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id' // Validate each ingredient ID exists
        ]);

        // Update the pizza name
        $pizza->name = $request->name;
        $pizza->save();

        // Update the ingredients relationship
        $pizza->ingredients()->sync($request->ingredients);

        return redirect()->route('pizzas')->with('success', 'Pizza updated successfully.');
    }


    // Remove the specified pizza from storage
    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->route('pizzas')->with('success', 'Pizza deleted successfully.');
    }
}
