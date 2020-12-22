<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "payload" => [
                    "message" => $validator->errors()
                ],
                "error" => [
                    "code" => 400,
                    "message" => "Bad Request"
                ]
            ], 400);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                "success" => false,
                "payload" => [
                    "message" => "E-mail ou senha inválidos"
                ],
                "error" => [
                    "code" => 401,
                    "message" => "Unauthorized"
                ]
            ], 401);
        }

        return $this->respondWithToken($token, 200);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "payload" => [
                    "message" => $validator->errors()
                ],
                "error" => [
                    "code" => 400,
                    "message" => "Bad Request"
                ]
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token, 201);
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

        return response()->json([
            "success" => true,
            "payload" => [
                'message' => 'Desconectado com sucesso'
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

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $code)
    {
        return response()->json([
            "success" => true,
            "payload" => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
            "links" => [
                [
                    "href" => "",
                    "rel" => "",
                    "type" => ""
                ],
            ]
        ], $code);
    }
}
