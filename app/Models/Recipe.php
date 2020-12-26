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

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
