<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RecipeTest extends TestCase
{
    public function testGetAllRecipes()
    {
        $recipes = Recipe::all();

        $response = $this->getJson('/api/recipe');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($recipes) { 
            return $json->where('success', true)
                ->where('message', "Receitas recuperadas")
                // ->has("data", $recipes->count())
                ->has("data.0", function($json) use ($recipes) { 
                    return $json->where('id', $recipes[0]->id)   
                        ->where('name', $recipes[0]->name) 
                        ->etc();
                });
            }
        );
    }

    public function testGetRecipeById()
    {
        $recipe = Recipe::find(1);

        $response = $this->getJson("/api/recipe/{$recipe->id}");

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($recipe) { 
            return $json->where('success', true)
                ->where('message', "Receita recuperada")
                ->where('data.id', 1)
                ->where('data.name', $recipe->name)
                ->etc();
        });
    }

    public function testStoreRecipeImage()
    {
        $this->markTestSkipped('must be revisited.');

        Storage::fake('local');
        $file = UploadedFile::fake()->image('image.png');
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post("api/recipe/image", ["image" => $file]);
        $imagePath = $response->original;
        
        Storage::disk("local")->assertExists("recipes/tmp/{$imagePath}/" . $file->getClientOriginalName());
        $response->assertStatus(200);
        $this->assertDatabaseHas("temporary_files", ["folder" => $imagePath]);

        return $imagePath;
    }
    
    /**
     * @depends testStoreRecipeImage
     */
    public function testStoreRecipeData($imagePath) 
    {
        Storage::fake('local');
        $recipe = Recipe::factory()->make([
            "image" => $imagePath
        ]);
        $ingredient_list = Ingredient::factory(5)->make();
        $user = User::factory()->create();

        $data = array_merge($recipe->toArray(), ["list_of_ingredients" => $ingredient_list->toArray()]);

        $response = $this->actingAs($user, 'api')->postJson("api/recipe", $data);

        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json) use ($recipe, $ingredient_list, $user) { 
            return $json->where('success', true)
                ->where('message', "Receita salva")
                ->where('data.name', $recipe->name)
                ->where('data.category_id', $recipe->category_id)
                ->where('data.user_id', $user->id)
                ->where('data.number_of_servings', $recipe->number_of_servings)
                ->where('data.cooking_time', $recipe->cooking_time)
                ->where('data.how_to_cook', $recipe->how_to_cook)
                ->has("data.image")
                ->has('data.ingredients', $ingredient_list->count(), function ($json) use ($ingredient_list) {
                    return $json->where('name', ucfirst($ingredient_list[0]->name))
                        ->where('quantity', $ingredient_list[0]->quantity)
                        ->where('measure', $ingredient_list[0]->measure);
                })
                ->etc();
        });
        $this->assertDatabaseMissing("temporary_files", ["folder" => $imagePath]);
    }
}
