<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeCollection extends ResourceCollection
{
    private $text;
    public function __construct($obj, $text)
    {
        parent::__construct($obj);
        $this->text = $text;

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
            "data" => $this->collection
        ];
    }

    public function with($request) {
        return [
            "success" => true,
            "message" => $this->text,
        ];
    }
}
