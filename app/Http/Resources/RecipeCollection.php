<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeCollection extends ResourceCollection
{
    private $text;
    private $researched_ingredients;
    public function __construct($obj, $text, $researched_ingredients = [])
    {
        parent::__construct($obj);
        $this->text = $text;
        $this->researched_ingredients = $researched_ingredients;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "success" => true,
            "message" => $this->text,
            "data" => $this->collection,
            $this->mergeWhen($this->researched_ingredients, [
                "researched_ingredients" => $this->researched_ingredients
            ])
        ];
    }

    // public function with($request) {
    //     return [
    //         "success" => true,
    //         "message" => $this->text,
    //     ];
    // }
}
