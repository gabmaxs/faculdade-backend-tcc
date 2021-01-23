<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return new CategoryCollection($categories, "Categorias recuperadas com sucesso");
    }

    public function show(Category $category) {
        return new CategoryResource($category, "Categoria recuperada com sucesso");
    }
}
