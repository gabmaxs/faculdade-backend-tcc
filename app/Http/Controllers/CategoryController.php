<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return response()->json([
            "success" => true,
            "payload" => [
                'message' => 'Categorias recuperadas com sucesso',
                'data' => $categories
            ],
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ], 200);
    }
}
