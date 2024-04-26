<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Check if the user is authenticated
    if (Auth::check()) {
        // Redirect authenticated users to the 'customer' route
        return redirect()->route('customer');
    }

    // If the user is not authenticated, return the login view
    return view('auth.login');
});

//Accessible by any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get( '/customer', [CustomerController::class,'customer'])->name('customer');
    // Admin only routes
    Route::middleware(['auth', 'roles'])->group(function () {
        //Manage Ingredients
        Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients');
        Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
        Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
        Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
        Route::patch('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
        Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

        //Manage Pizzas
        Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas');
        Route::get('/pizzas/create', [PizzaController::class, 'create'])->name('pizzas.create');
        Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
        Route::get('/pizzas/{pizza}/edit', [PizzaController::class, 'edit'])->name('pizzas.edit');
        Route::patch('/pizzas/{pizza}', [PizzaController::class, 'update'])->name('pizzas.update');
        Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');

        //Order Pizzas
        Route::post('/ingredients/{ingredient}/move-up', [IngredientController::class, 'moveUp'])->name('ingredients.moveUp');
        Route::post('/ingredients/{ingredient}/move-down', [IngredientController::class, 'moveDown'])->name('ingredients.moveDown');
    });
});

require __DIR__.'/auth.php';
