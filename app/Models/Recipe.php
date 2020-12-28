<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "image", "number_of_servings", "cooking_time", "how_to_cook", "category_id", "user_id"
    ];

    protected $casts = [
        "how_to_cook" => "array"
    ];

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class)->withPivot("quantity","measure")->as("details");
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
