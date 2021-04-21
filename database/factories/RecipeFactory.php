<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(), 
            "image" => env("STORAGE_URL")."/public%2Fdefault.png?alt=media", 
            "number_of_servings" => $this->faker->numberBetween(1,10), 
            "cooking_time" => $this->faker->randomNumber(2), 
            "how_to_cook" => $this->faker->sentences(5), 
            "category_id" => $this->faker->numberBetween(1,10),
            "user_id" => 1
        ];
    }

    public function configure()
    {
        $ingredients_list = Ingredient::factory($this->faker->randomDigitNotNull())->make()->toArray();
        return $this->afterCreating( function (Recipe $recipe) use ($ingredients_list) { return $recipe->saveIngredients($ingredients_list); });
    }
}
