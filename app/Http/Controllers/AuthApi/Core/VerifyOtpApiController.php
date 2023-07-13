<?php

namespace App\Http\Controllers\AuthApi\Core;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class VerifyOtpApiController extends Controller
{

    public function __invoke(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email|exists:users',
            'otp'   => 'required|numeric',
        ]);

        $otp_history = DB::table('password_reset_tokens')
            ->where(['email' => $data['email'], 'token' => $data['otp']])
            ->first();

        if ($otp_history) {
            return response::json([
                'message' => 'Your OTP is valid',
            ]);
        }

        return response::json([
            'message' => 'Invalid OTP',
        ], 404);
    }
}
