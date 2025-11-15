<?php

use App\Http\Controllers\CocktailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('cocktails.api');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cocktails/api', [CocktailController::class, 'indexApi'])->name('cocktails.api');
    Route::post('/cocktails/store', [CocktailController::class, 'store'])->name('cocktails.store');
    Route::get('/cocktails/stored', [CocktailController::class, 'storedIndex'])->name('cocktails.stored');
    Route::get('/cocktails/{cocktail}/edit', [CocktailController::class, 'edit'])->name('cocktails.edit');
    Route::put('/cocktails/{cocktail}', [CocktailController::class, 'update'])->name('cocktails.update');
    Route::delete('/cocktails/{cocktail}', [CocktailController::class, 'destroy'])->name('cocktails.destroy');
});

require __DIR__ . '/auth.php';
