<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Http\Resources\Recipe as RecipeResource;
use App\Http\Resources\RecipeCollection;
use App\Models\TemporaryFile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

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
            "list_of_ingredients.*.name" => "required|string|max:255",
            "list_of_ingredients.*.quantity" => "required|numeric",
            "list_of_ingredients.*.measure" => "required|string|max:255|" . Rule::in(config("measures.available")),
            "image" => "nullable|string"
        ]);

        $recipe = $user->recipes()->create([
            "name" => $request->name,
            "number_of_servings" => $request->number_of_servings,
            "cooking_time" => $request->cooking_time,
            "how_to_cook" => $request->how_to_cook,
            "category_id" => $request->category_id,
            "image" => env('STORAGE_URL') . "/public%2Fdefault.png?alt=media"
        ]);
        $recipe->saveIngredients($request->get('list_of_ingredients'));
        if($request->has("image") && !empty($request->get("image"))) {
            $temporaryFile = TemporaryFile::where("folder", $request->image)->first();
            if($temporaryFile) {
                $recipe->saveImage("recipes/tmp/{$request->image}/", $temporaryFile->filename);
                $temporaryFile->delete();
            }
        }

        return (new RecipeResource($recipe,Recipe::message("created")))->response()->setStatusCode(201);
    }

    public function show(Recipe $recipe) {
        $data = $recipe->with("Ingredients")->where('recipes.id',$recipe->id)->first();
        return new RecipeResource($data,Recipe::message("show"));
    }

    public function index(Request $request) {
        $recipes = Recipe::searchRecipes()
            ->minTime($request->query('min_time', 0))
            ->maxTime($request->query('max_time', 0))
            ->category($request->query('category', 0))
            ->withIngredients($request->query("ingredients", []))
            ->forPage($request->query("page",1),$request->query("limit",15))
            ->values();
        
        return new RecipeCollection($recipes,Recipe::message("index"), $request->query("ingredients", []));
    }

    public function like(Recipe $recipe) {
        $user = auth()->user();

        $user->likedRecipes()->toggle([$recipe->id]);

        return response()->json([
            "success" => true,
            "message" => "Recipe {$recipe->name} updated",
            "data" => $recipe
        ]);
    }

    public function isLiked(Recipe $recipe) {
        $user = auth()->user();

        $contains = $user->likedRecipes()->where("recipe_id", $recipe->id)->first();

        return response()->json([
            "success" => true,
            "message" => "Recipe {$recipe->name} info",
            "data" => $contains != null ? true : false
        ]);
    }

    public function storeMany(Request $request) {
        $user = User::find(1);

        $request->validate([
            "recipes" => "array"
        ]);

        $recipesData = collect($request->get("recipes"));
        $recipes = collect([]);

        $recipesData->each(function ($recipe) use($user, $recipes) {
            $storedRecipe = $user->recipes()->create([
                "name" => $recipe['name'],
                "number_of_servings" => $recipe['number_of_servings'],
                "cooking_time" => $recipe['cooking_time'],
                "how_to_cook" => $recipe['how_to_cook'],
                "category_id" => $recipe['category_id'],
                "image" => env('STORAGE_URL') . "/public%2Frecipes%2F{$recipe['image']}?alt=media"
            ]);

            $list_of_ingredients = collect([]);
            foreach($recipe['list_of_ingredients'] as $ingredient) {
                $array = explode(" ", $ingredient);
                $list_of_ingredients->push([
                    "name" => str_replace("-", " ", $array[2]),
                    "quantity" => $array[0],
                    "measure" => str_replace("-", " ", $array[1])
                ]);
            }

            $storedRecipe->saveIngredients($list_of_ingredients->toArray());
    
            $recipes->push($storedRecipe);
        });

        return (new RecipeCollection($recipes ,Recipe::message("created")))->response()->setStatusCode(201);
    }
}
