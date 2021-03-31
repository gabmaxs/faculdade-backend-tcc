<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(2, 30),
            'measure' => $this->faker->randomElement([
                "Litro",
                "Unidade",
                "Xícara",
                "Colher de chá",
                "Colher de sopa",
                "Gramas"
            ])
        ];
    }
}
