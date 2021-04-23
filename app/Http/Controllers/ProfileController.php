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
            'culinary_level' => 'required|max:10|numeric',
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
    public function update(Request $request, Profile $profile)
    {
        $user = auth()->user();

        $request->validate([
            'culinary_level' => 'required|max:10|numeric',
            'gender' => 'required|string|max:255',
            'photo' => 'nullable',
        ]);

        $profile = $user->profile;
        $profile->fill([
            "culinary_level" => $request->culinary_level,
            "gender" => $request->gender
        ]);
        $profile->save();

        return new UserResource($user, "Perfil atualizado com sucesso");
    }
}
