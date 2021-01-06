<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            "success" => true,
            "message" => $this->text,
            "data" => $this->collection
        ];
    }
}
