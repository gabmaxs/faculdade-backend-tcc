<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Testing\Fluent\AssertableJson;

class RecipeSearchTest extends TestCase
{
    public function testSimpleSearch() {
        $query = [
            "ingredients" => ["Laranja"]
        ];

        $response = $this->getJson(route("search", $query));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) { 
            return $json->where('success', true)
                ->where('message', "Receitas recuperadas")
                ->has("data", 1)
                ->where("researched_ingredients", ["Laranja"])
                ->has("data.0", function($json) { 
                    return $json->where('name', "Suco de laranja") 
                        ->where("matched_ingredients", ["Laranja"])
                        ->where("total_ingredients", 3)
                        ->etc();
                });
            }
        );
    }

    public function testMultipleIngredientsSearch() {
        $query = [
            "ingredients" => ["Laranja", "Água"]
        ];

        $response = $this->getJson(route("search", $query));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) { 
            return $json->where('success', true)
                ->where('message', "Receitas recuperadas")
                ->has("data", 2)
                ->where("researched_ingredients", ["Laranja", "Água"])
                ->has("data.0", function($json) { 
                    return $json->where('name', "Suco de laranja") 
                        ->where("matched_ingredients", ["Laranja", "Água"])
                        ->where("total_ingredients", 3)
                        ->etc();
                })
                ->has("data.1", function($json) { 
                    return $json->where('name', "Limonada") 
                        ->where("matched_ingredients", ["Água"])
                        ->where("total_ingredients", 3)
                        ->etc();
                });
            }
        );
    }
}
