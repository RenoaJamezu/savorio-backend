<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreRecipeRequest;
use App\Http\Requests\v1\UpdateRecipeRequest;
use App\Http\Resources\v1\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Recipe::with('user');

        // search by recipe title and user
        if ($request->has('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $recipe = $query->paginate(6);

        return RecipeResource::collection($recipe);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        $this->authorize('create', Recipe::class); // check policy

        $recipe = Recipe::create($request->validated());
        $recipe->load('user');

        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $this->authorize('view', $recipe);

        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        
        // Only update fields that are present in the request
        $data = array_filter($request->validated(), function ($value) {
            return $value !== null; // ignore nulls
        });

        $recipe->update($data);

        return new RecipeResource($recipe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'recipe delete successfully',
            'recipe' => $recipe,
        ]);
    }
}
