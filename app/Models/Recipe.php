<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "image", "number_of_servings", "cooking_time", "how_to_cook", "category_id", "user_id"
    ];

    protected $casts = [
        "how_to_cook" => "array"
    ];

    protected $hidden = ["pivot"];

    protected $appends = ["links"];

    public static $message = [
        "show" => "Receita recuperada com sucesso",
        "created" => "Receita criada com sucesso",
        "index" => "Receitas recuperadas com sucesso"
    ];

    public static function message($text) {
        return self::$message[$text];
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class)->withPivot("quantity","measure");
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    protected function getLinksAttribute() {
        return [
            [
                "href" => env("APP_URL")."/api/recipe/{$this->id}",
                "rel" => "self",
                "type" => "GET"
            ],
            [
                "href" => env("APP_URL")."/api/recipe/{$this->id}",
                "rel" => "update",
                "type" => "PUT"
            ],
        ];
    }
}
