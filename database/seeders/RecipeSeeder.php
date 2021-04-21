<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = [
            [
                "name" => "Limonada",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2Flimonada.jpeg?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 5,
                "how_to_cook" => [
                    "Esprema os limões em uma jarra",
                    "Coloque a água",
                    "Adicione o açúcar",
                    "Misture tudo"
                ],
                "category_id" => 2,
                "user_id" => 1,
            ],
            [
                "name" => "Suco de laranja",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2Flaranja.png?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 15,
                "how_to_cook" => [
                    "Esprema as laranjas em uma jarra",
                    "Coloque a água",
                    "Adicione o açúcar",
                    "Misture tudo"
                ],
                "category_id" => 2,
                "user_id" => 1,
            ],
        ];

        $ingredients = [
            [
                [
                    "name" => "Limão",
                    "quantity" => 5,
                    "measure" => "unidade"
                ],
                [
                    "name" => "Água",
                    "quantity" => 1,
                    "measure" => "litro"
                ],
                [
                    "name" => "Açúcar",
                    "quantity" => 3,
                    "measure" => "colher de chá"
                ]
            ],
            [
                [
                    "name" => "Laranja",
                    "quantity" => 5,
                    "measure" => "unidade"
                ],
                [
                    "name" => "Água",
                    "quantity" => 1,
                    "measure" => "litro"
                ],
                [
                    "name" => "Açúcar",
                    "quantity" => 5,
                    "measure" => "colher de chá"
                ]
            ]
        ];


        foreach($recipes as $key => $recipe_array) {
            $recipe = Recipe::create($recipe_array);
            $recipe->saveIngredients($ingredients[$key]);
        }
    }
}
