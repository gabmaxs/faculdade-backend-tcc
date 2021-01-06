<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ingredient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name" => $this->name,
            "quantity" => $this->whenPivotLoaded('ingredient_recipe', function () {
                return $this->pivot->quantity;
            }),
            "measure" => $this->whenPivotLoaded('ingredient_recipe', function () {
                return $this->pivot->measure;
            })
        ];
    }
}
