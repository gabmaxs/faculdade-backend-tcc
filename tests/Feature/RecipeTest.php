<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Testing\Fluent\AssertableJson;

class RecipeTest extends TestCase
{
    public function testGetAllRecipes()
    {
        $recipes = Recipe::all();

        $response = $this->getJson('/api/recipe');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $json->where('success', true)
                ->where('message', "Receitas recuperadas")
                ->has("data", $recipes->count())
                ->has("data.0", fn($json) => 
                    $json->where('id', $recipes[0]->id)   
                        ->where('name', $recipes[0]->name) 
                        ->etc()
                )
        );
    }

    public function testGetRecipeById()
    {
        $recipe = Recipe::find(1);

        $response = $this->getJson("/api/recipe/{$recipe->id}");

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $json->where('success', true)
                ->where('message', "Receita recuperada")
                ->where('data.id', 1)
                ->where('data.name', $recipe->name)
                ->etc()
        );
    }
}
