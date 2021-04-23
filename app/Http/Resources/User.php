<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
        $profile = new Profile($this->profile);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            $this->mergeWhen(isset($profile->culinary_level), [
                "culinary_level" => $profile->culinary_level ?? null, 
                "gender" => $profile->gender ?? null, 
                "photo" => $profile->photo ?? null
            ]),
        ];
    }

    public function with($request) {
        return [
            "success" => true,
            "message" => $this->text
        ];
    }
}
