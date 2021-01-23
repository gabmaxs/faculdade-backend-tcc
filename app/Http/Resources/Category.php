<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
        ];
    }

    public function with($request) {
        return [
            "success" => true,
            "message" => $this->text
        ];
    }
}
