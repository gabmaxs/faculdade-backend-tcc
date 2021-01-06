<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    protected $hidden = [
        "id", "created_at", "updated_at"
    ];

    public function recipes() {
        return $this->belongsToMany(Recipe::class);
    }

    public function toArray()
    {
        $attributes = $this->attributesToArray();
        $attributes = array_merge($attributes, $this->relationsToArray());

        if (isset($attributes['pivot'])) {
            $attributes['quantity'] = $attributes['pivot']['quantity'];
            $attributes['measure'] = $attributes['pivot']['measure'];
            unset($attributes['pivot']);
        }
        return $attributes;
    }
}
