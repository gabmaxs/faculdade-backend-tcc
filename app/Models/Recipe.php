<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "image", "number_of_servings", "cooking_time", "how_to_cook", "category_id", "user_id"
    ];

    protected $casts = [
        "how_to_cook" => "array"
    ];

    public static $message = [
        "show" => "Receita recuperada",
        "created" => "Receita salva",
        "index" => "Receitas recuperadas",
        "image" => "Imagem da receita salva"
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

    public function saveImage(UploadedFile $image) {
        $path = $image->store("public/recipes");

        $this->attributes['image'] = env("APP_URL").Storage::url($path);
        $this->save();
    }

    public function saveIngredients($list_of_ingredients) {
        foreach($list_of_ingredients as $ingredient_array) {
            $ingredient = Ingredient::firstOrCreate([
                "name" => ucfirst($ingredient_array["name"])
            ]);
            $this->ingredients()->attach($ingredient->id, [
                "quantity" => $ingredient_array["quantity"],
                "measure" => $ingredient_array["measure"]
            ]);
        }
    }
}
