<?php

namespace App\Http\Controllers\AuthApi\Core;

use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class RegistrationApiController extends Controller
{
    public function __invoke(Request $request)
    {

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'max:100', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $user             = User::create($data);

        // in future use device name instead of "bearerToken". check sanctum documentation
        $token = $user->createToken('bearerToken')->plainTextToken;

        $response_data = [
            'message' => "User Registration successful",
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'    => UserResource::make($user),
        ];

        return Response::json($response_data);
    }
}
