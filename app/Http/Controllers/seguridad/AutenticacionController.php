<?php

namespace App\Http\Controllers\seguridad;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;

class AutenticacionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login']);
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'min:6', 'max:100', 'email', "exists:App\Models\User,email"],
                'password' => ['required', 'min:6']
            ],
            [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.min' => 'El correo electrónico no puede tener menos de :min caracteres.',
                'email.max' => 'El correo electrónico no puede tener más de :max caracteres.',
                'email.email' => 'El correo electrónico no tiene el formato correcto.',
                'email.exists' => 'El correo electrónico no se encuentra registrado.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña no puede tener menos de :min caracteres.',
            ]
        );

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'error' => 'El usuario o contraseña es incorrecto', 'code' => '401'
            ], 401);
        }

        $http = new Client();

        $response = $http->post(config('app.server_auth') . 'seguridad/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 2,
                'client_secret' => "t6LqVNQoiMx7aYceb44vBupKptrzXLF9MJ5OGdOD",
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '*',
            ],
        ]);

        $token = \json_decode($response->getBody()->getContents());

        return response()->json([
            'access_token' => $token->access_token,
            'usuario' => $request->user(),
            'token_type'   => $token->token_type,
            'expires_at'   => $token->expires_in
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'saliendo...']);
    }
}
