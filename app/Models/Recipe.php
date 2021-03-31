<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

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

    public function getResearchedIngredientsAttribute() {
        return $this->attributes['researched_ingredients'] ?? [];
    }

    public function setResearchedIngredientsAttribute($value) {
        if(!isset($this->attributes['researched_ingredients']))
            $this->attributes['researched_ingredients'] = [];

        array_push($this->attributes['researched_ingredients'], $value);
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class)->withPivot("quantity","measure");
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function saveImage($folder, $file) {
        if(Storage::disk("local")->exists($folder.$file)) {
            $path = Storage::putFile("public/recipes", new File(Storage::path($folder.$file)));
    
            $this->attributes['image'] = env("APP_URL").Storage::url($path);
            $this->save();

            Storage::deleteDirectory($folder);
        }
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

    public function hasIngredient($ingredientName) {
        return $this->ingredients()->get()->contains(function ($ingredient) use ($ingredientName) {
            return $ingredient->name == $ingredientName;
        });
    }

    private function numberOfMatchedIngredients($ingredients) {
        $numberOfIngredients = 0;
        foreach($ingredients as $ingredientName) {
            if($this->hasIngredient($ingredientName)){
                $numberOfIngredients++;
                $this->researched_ingredients = $ingredientName;
            }
        }
        return $numberOfIngredients;
    }

    public function scopeSearchRecipes($query, $request) {
        return $query->with('ingredients')
            ->select("recipes.id", "recipes.name", "recipes.image", "recipes.created_at", "recipes.updated_at", "recipes.category_id", "recipes.user_id");
    }

    public function scopeMinTime($query, $value) {
        if($value > 0) 
            return $query->where('recipes.cooking_time','>=', $value);
        
        return $query;
    }

    public function scopeMaxTime($query, $value) {
        if($value > 0) 
            return $query->where('recipes.cooking_time','<=', $value);
        
        return $query;
    }

    public function scopeCategory($query, $value) {
        if($value > 0) 
            return $query->where('recipes.category_id', $value);
        
        return $query;
    }

    public function scopeIngredients($query, $ingredients) {
        return $query->get()->sortByDesc(fn($recipe) => $recipe->numberOfMatchedIngredients($ingredients));
    }
}
