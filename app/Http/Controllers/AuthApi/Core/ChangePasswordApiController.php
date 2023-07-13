<?php

namespace App\Http\Controllers\AuthApi\Core;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ChangePasswordApiController extends Controller {

    public function __invoke(Request $request) {

        $data = $request->validate([
            'current_password'      => 'required|string|min:6',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $hashedPassword = Auth::user()->password;
        $email          = Auth::user()->email;

        if (Hash::check($data['current_password'], $hashedPassword)) {

            $user           = User::where('email', $email)->first();
            $user->password = Hash::make($data['password']);
            $user->save();

            return Response::json(['message' => 'Password changed successfully.'], 200);

        } else {

            return Response::json(['message' => 'Current password did not match.'], 422);

        }

    }
}