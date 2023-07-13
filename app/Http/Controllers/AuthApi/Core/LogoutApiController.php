<?php

namespace App\Http\Controllers\AuthApi\Core;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutApiController extends Controller {

    public function __invoke() {

        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

}
