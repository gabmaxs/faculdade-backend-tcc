<?php

namespace App\Http\Controllers;

use App\Facade\Response;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class ProfileController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'culinary_level' => 'required|max:5|numeric',
            'gender' => 'required|string|max:255',
            'photo' => 'nullable',
        ]);

        $user->profile()->create([
            "culinary_level" => $request->culinary_level,
            "gender" => $request->gender
        ]);

        return (new UserResource($user, "Perfil criado com sucesso"))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();
        return new UserResource($user, "Usuário recuperado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'culinary_level' => 'required|max:5|numeric',
            'gender' => 'required|string|max:255',
            'photo' => 'nullable',
            'name' => "required|max:255|string"
        ]);

        $user->fill($request->only("name"));
        $user->save();
        $user->profile()->updateOrCreate(["user_id" => $user->id], $request->only("culinary_level", "gender", "photo"));
        
        return new UserResource($user, "Perfil atualizado");
    }

    public function like() {
        $user = auth()->user();

        $recipes = $user->likedRecipes->map(function ($recipe) {
            return $recipe->only(["id", "name", "category_id"]);
        });

        return response()->json([
            "success" => true,
            "message" => "Suas receitas preferidas",
            "data" => $recipes
        ]);
    }
}
