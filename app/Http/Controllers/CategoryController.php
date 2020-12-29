<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Facade\Response;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return response()->json(Response::success($categories, "Categorias recuperadas com sucesso"),200);
    }
}
