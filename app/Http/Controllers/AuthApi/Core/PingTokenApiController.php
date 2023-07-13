<?php

namespace App\Http\Controllers\AuthApi\Core;

use Illuminate\Routing\Controller;

class PingTokenApiController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'message' => 'Your token is valid',
        ]);
    }
}
