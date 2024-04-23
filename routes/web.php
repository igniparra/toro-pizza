<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});




// Admin only route
Route::get('/admin', function () {
    if (auth()->user()->role !== 'admin') {
        abort(403);  //Forbidden access if not admin
    }
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

//Accessible by any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get( '/customer', [PizzaController::class,'customer'])->name('customer');
    // Admin only routes
    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403);  // Forbidden access if not admin
        }
        return app(PizzaController::class)->admin();
    })->middleware(['verified'])->name('admin');
});

require __DIR__.'/auth.php';
