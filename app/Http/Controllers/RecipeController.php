<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Facade\Response;
use App\Http\Resources\Recipe as RecipeResource;
use App\Http\Resources\RecipeCollection;

class RecipeController extends Controller
{
    public function store(Request $request) {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "image" => "required|file|mimes:jpg,gif,png,jpeg|max:2048",
            "number_of_servings" => "required|numeric|max:50",
            "cooking_time" => "required|numeric|max:360",
            "how_to_cook" => "required|array|max:2000",
            "category_id" => "required|numeric",
            "list_of_ingredients" => "required|array|max:2000",
        ]);

        if ($validator->fails()) {
            return response()->json(Response::error($validator->errors()), 400);
        }

        $path = $request->file("image")->store("public/recipes");
        $url = env("APP_URL").Storage::url($path);

        $recipe = $user->recipes()->create([
            "name" => $request->name,
            "image" => $url,
            "number_of_servings" => $request->number_of_servings,
            "cooking_time" => $request->cooking_time,
            "how_to_cook" => $request->how_to_cook,
            "category_id" => $request->category_id,
        ]);

        foreach($request->get('list_of_ingredients') as $ingredient_array) {
            $ingredient = Ingredient::firstOrCreate([
                "name" => ucfirst($ingredient_array["name"])
            ]);
            $recipe->ingredients()->attach($ingredient->id, [
                "quantity" => $ingredient_array["quantity"],
                "measure" => $ingredient_array["measure"]
            ]);
        }

        $data = $recipe->with("Ingredients")->where('recipes.id',$recipe->id)->first();
        return (new RecipeResource($data,Recipe::message("created")))->response()->setStatusCode(201);
    }

    public function show(Recipe $recipe) {
        $data = $recipe->with("Ingredients")->where('recipes.id',$recipe->id)->first();
        return new RecipeResource($data,Recipe::message("show"));
    }

    public function index(Request $request) {
        $recipes = Recipe::join("ingredient_recipe", "recipes.id", "=", "ingredient_recipe.recipe_id")
            ->join("ingredients", "ingredient_recipe.ingredient_id", "ingredients.id")
            ->select("recipes.id", "recipes.name", "recipes.image", "recipes.created_at", "recipes.updated_at", "recipes.category_id", "recipes.user_id");

        if($request->has("limit")) $recipes->take($request->query('limit'));
        if($request->has("category")) $recipes->where('recipes.category_id',$request->query('category'));
        if($request->has("min_time")) $recipes->where('recipes.cooking_time','>=',$request->query('min_time'));
        if($request->has("max_time")) $recipes->where('recipes.cooking_time','<=',$request->query('max_time'));
        if($request->has("ingredients")) $recipes->whereIn("ingredients.name", $request->query("ingredients"));
        
        return new RecipeCollection($recipes->groupBy("recipes.id")->get(),Recipe::message("index"));
    }
}
