<?php

namespace App\Http\Controllers\AuthApi\Core;

use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class RequestOtpApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'exists:users'],
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        DB::table('password_reset_tokens')->insert([
            'email'      => $data['email'],
            'token'      => $otp,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($data['email'])->send(new OtpMail($otp));

        return response::json([
            'message' => 'OTP has been sent to ' . $data['email'] . ' successfully.',
        ]);
    }
}
