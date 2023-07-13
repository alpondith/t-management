<?php

namespace App\Http\Controllers\AuthApi\Core;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ResetPasswordApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email'                 => 'required|email|exists:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'otp'                   => 'required|numeric',
        ]);

        $otp_history = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'token' => $request->otp])
            ->first();

        if (!$otp_history) {
            return response::json([
                'message' => 'Invalid OTP',
            ], 404);
        }

        $user           = User::where('email', $data['email'])->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return response::json([
            'message' => 'Your password has been changed successfully',
        ]);
    }
}
