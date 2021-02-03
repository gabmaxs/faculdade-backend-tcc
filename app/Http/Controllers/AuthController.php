<?php

namespace App\Http\Controllers;

use App\Facade\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
        
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);
        if(!$token) throw new AuthenticationException();

        return $this->respondWithToken($token, "Login realizado com sucesso", 200);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = auth()->login($user);
        if(!$token) throw new AuthenticationException();

        return $this->respondWithToken($token, "Registro realizado com sucesso", 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        $links = [
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ];

        return response()->json(Response::success($links, 'Desconectado com sucesso'),200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), "Atualização de token realizado com sucesso", 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message, $code)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return response()->json(Response::success($data, $message),$code);
    }
}
