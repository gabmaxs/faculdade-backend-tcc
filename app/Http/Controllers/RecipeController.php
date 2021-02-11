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
            "image" => "required|file|mimes:jpg,gif,png,jpeg|max:2048",
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
        $recipe->saveImage($request->file("image"));
        $recipe->saveIngredients($request->get('list_of_ingredients'));

        return (new RecipeResource($recipe,Recipe::message("created")))->response()->setStatusCode(201);
    }

    public function show(Recipe $recipe) {
        $data = $recipe->with("Ingredients")->where('recipes.id',$recipe->id)->first();
        return new RecipeResource($data,Recipe::message("show"));
    }

    public function index(Request $request) {
        $recipes = Recipe::join("ingredient_recipe", "recipes.id", "=", "ingredient_recipe.recipe_id")
            ->join("ingredients", "ingredient_recipe.ingredient_id", "ingredients.id")
            ->select("recipes.id", "recipes.name", "recipes.image", "recipes.created_at", "recipes.updated_at", "recipes.category_id", "recipes.user_id");

        if($request->has("category")) $recipes->where('recipes.category_id',$request->query('category'));
        if($request->has("min_time")) $recipes->where('recipes.cooking_time','>=',$request->query('min_time'));
        if($request->has("max_time")) $recipes->where('recipes.cooking_time','<=',$request->query('max_time'));
        if($request->has("ingredients")) $recipes->whereIn("ingredients.name", $request->query("ingredients"));
        
        if($request->has("limit")) $recipes = $recipes->groupBy("recipes.id")->paginate($request->query("limit"));
        else $recipes = $recipes->groupBy("recipes.id")->paginate(15);

        return new RecipeCollection($recipes,Recipe::message("index"));
    }
}
