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
            $this->mergeWhen($profile, [
                "culinary_level" => $profile->culinary_level, 
                "gender" => $profile->gender, 
                "photo" => $profile->photo
            ]),
        ];
    }
}
