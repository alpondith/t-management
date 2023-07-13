<?php

namespace App\Http\Controllers\AuthApi\Core;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    // https://laravel.com/docs/8.x/sanctum#issuing-mobile-api-tokens
    public function __invoke(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['incorrect credentials'],
            ]);
        }

        // in future use device name instead of "bearerToken". check sanctum documentation
        $token = $user->createToken('bearerToken')->plainTextToken;

        $response_data = [
            'message' => "login successful",
            'access_token'  =>  $token,
            'token_type'    => 'Bearer',
            'id'            =>  $user->id,
            'name'          =>  $user->name,
            'email'         =>  $user->email,
        ];

        return Response::json($response_data);
    }
}
