<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function store(Request $request) {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "image" => "nullable|string|max:255",
            "number_of_servings" => "required|numeric|max:50",
            "cooking_time" => "required|numeric|max:360",
            "how_to_cook" => "required|array|max:2000",
            "category_id" => "required|numeric",
            "list_of_ingredients" => "required|array|max:2000",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "payload" => [
                    "message" => $validator->errors()
                ],
                "error" => [
                    "code" => 400,
                    "message" => "Bad Request"
                ]
            ], 400);
        }

        $recipe = $user->recipes()->create([
            "name" => $request->name,
            "image" => $request->image,
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

        return response()->json([
            "success" => true,
            "payload" => [
                'message' => 'Receita criada com sucesso',
                'data' => $recipe->with("Ingredients")->get()
            ],
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ], 201);
    }

    public function show(Recipe $recipe) {
        return response()->json([
            "success" => true,
            "payload" => [
                'message' => 'Receita recuperada com sucesso',
                'data' => $recipe->with("Ingredients")->get()
            ],
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ], 200);
    }

    public function index() {
        $recipes = Recipe::all();
        return response()->json([
            "success" => true,
            "payload" => [
                'message' => 'Receitas recuperadas com sucesso',
                'data' => $recipes
            ],
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ], 200);
    }
}
