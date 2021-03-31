<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "culinary_level" => $this->faker->numberBetween(1,5), 
            "gender" => $this->faker->randomElement(["M", "F"]), 
            "photo" => "/path/to/photo"
        ];
    }
}
