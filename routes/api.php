<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\RecipeController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

// public routes

// authentication
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// public Recipes
Route::get('v1/recipes', [RecipeController::class, 'index']);
Route::get('v1/statistics', function() {
    return response()->json([
        'total_recipes' => Recipe::count(),
    ]);
});

// logout
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// protected routes (requires authentication)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // recipe CRUD
    Route::apiResource('recipes', RecipeController::class)
        ->only(['store', 'show', 'update', 'destroy']);
});