<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\RecipeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {

    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Public Recipes
    Route::get('recipes', [RecipeController::class, 'index']);
});

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // Authentication
    Route::post('logout', [AuthController::class, 'logout']);

    // Recipe CRUD
    Route::apiResource('recipes', RecipeController::class)
        ->only(['store', 'show', 'update', 'destroy']);
});