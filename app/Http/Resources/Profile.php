<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            "culinary_level" => $this->culinary_level, 
            "gender" => $this->gender, 
            "photo" => $this->photo
        ];
    }
}
