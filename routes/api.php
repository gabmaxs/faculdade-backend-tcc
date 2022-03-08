<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["middleware" => "api", "prefix" => "auth"], function ($router) {
    Route::post("login", "AuthController@login")->name("login");
    Route::post("register", "AuthController@register");
    Route::post("logout", "AuthController@logout");
    Route::post("refresh", "AuthController@refresh");
});

Route::middleware(["auth:api"])->group(function () {
    Route::post("user/profile", "ProfileController@store");
    Route::put("user/profile", "ProfileController@update");
    Route::get("user/profile", "ProfileController@show");
    Route::post("recipe", "RecipeController@store");
});

Route::post("recipe/many", "RecipeController@storeMany");
Route::post("recipe/image", "TemporaryFileController@upload");
Route::get("recipe", "RecipeController@index")->name("search");
Route::get("recipe/{recipe}", "RecipeController@show");
Route::get("category", "CategoryController@index");
Route::get("category/{category}","CategoryController@show");

Route::get("measure", function () {
    return response()->json([
        "success" => true,
        "data" => config("measures.available"),
        "message" => "Unidades de medidas recuperadas"
    ]);
});

Route::fallback(function () {
    return response()->json([
        "success" => false,
        "message" => "Página não encontrada",
        "error" => [
            "code" => 404,
            "message" => "Not Found"
        ]
    ], 404);
});