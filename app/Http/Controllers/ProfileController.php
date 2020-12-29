<?php

namespace App\Http\Controllers;

use App\Facade\Response;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'culinary_level' => 'required|max:10|numeric',
            'gender' => 'required|string|max:255',
            'photo' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(Response::error($validator->errors()), 400);
        }

        $user->profile()->create([
            "culinary_level" => $request->culinary_level,
            "gender" => $request->gender
        ]);

        $data = $user->with("Profile")->where('id',$user->id)->get();
        return response()->json(Response::success($data, 'Perfil criado com sucesso'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
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
        //
    }
}
