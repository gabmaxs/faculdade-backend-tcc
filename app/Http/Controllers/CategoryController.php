<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return new CategoryCollection($categories, "Categorias recuperadas com sucesso");
    }
}
