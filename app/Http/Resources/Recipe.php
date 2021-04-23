<?php

namespace App\Http\Resources;

// use App\Models\Ingredient;
use Illuminate\Http\Resources\Json\JsonResource;

class Recipe extends JsonResource
{
    private $text;
    public function __construct($obj, $text)
    {
        parent::__construct($obj);
        $this->text = $text;

    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            $this->mergeWhen($this->matched_ingredients, [
                'total_ingredients' => $this->ingredients->count(),
                'matched_ingredients' => $this->matched_ingredients,
                ]),
            $this->mergeWhen($this->number_of_servings != null, [
                'number_of_servings' => $this->number_of_servings,
                'cooking_time' => $this->cooking_time,
                'ingredients' => new IngredientCollection($this->ingredients),
                'how_to_cook' => $this->how_to_cook,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                [
                    "href" => env("APP_URL")."/api/recipe/{$this->id}",
                    "rel" => "self",
                    "type" => "GET"
                ],
                [
                    "href" => env("APP_URL")."/api/recipe/{$this->id}",
                    "rel" => "update",
                    "type" => "PUT"
                ]
            ]
        ];
    }

    public function with($request) {
        return [
            "success" => true,
            "message" => $this->text
        ];
    }
}
