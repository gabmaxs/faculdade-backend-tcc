<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Recipe as RecipeResource;
use App\Http\Resources\RecipeCollection;

class RecipeController extends Controller
{
    public function store(Request $request) {
        $user = auth()->user();

        $request->validate([
            "name" => "required|string|max:255",
            "number_of_servings" => "required|numeric|max:50",
            "cooking_time" => "required|numeric|max:360",
            "how_to_cook" => "required|array|max:2000",
            "category_id" => "required|numeric",
            "list_of_ingredients" => "required|array|max:2000",
        ]);

        $recipe = $user->recipes()->create([
            "name" => $request->name,
            "number_of_servings" => $request->number_of_servings,
            "cooking_time" => $request->cooking_time,
            "how_to_cook" => $request->how_to_cook,
            "category_id" => $request->category_id,
        ]);
        $recipe->saveIngredients($request->get('list_of_ingredients'));

        return (new RecipeResource($recipe,Recipe::message("created")))->response()->setStatusCode(201);
    }

    public function show(Recipe $recipe) {
        $data = $recipe->with("Ingredients")->where('recipes.id',$recipe->id)->first();
        return new RecipeResource($data,Recipe::message("show"));
    }

    public function index(Request $request) {
        $recipes = Recipe::searchRecipes($request)
            ->minTime($request->query('min_time', 0))
            ->maxTime($request->query('max_time', 0))
            ->category($request->query('category', 0))
            ->ingredients($request->query("ingredients", []))
            ->forPage($request->query("page",1),$request->query("limit",15))
            ->values();
        
        return new RecipeCollection($recipes,Recipe::message("index"));
    }

    public function storeImage(Request $request, Recipe $recipe) {
        $request->validate([
            "image" => "required|file|mimes:jpg,gif,png,jpeg|max:2048",
        ]);

        $recipe->saveImage($request->file("image"));
        return (new RecipeResource($recipe,Recipe::message("image")))->response()->setStatusCode(201);
    }
}
