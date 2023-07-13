<?php

use App\Http\Controllers\AuthApi\Core\ChangePasswordApiController;
use App\Http\Controllers\AuthApi\Core\LoginApiController;
use App\Http\Controllers\AuthApi\Core\LogoutApiController;
use App\Http\Controllers\AuthApi\Core\PingTokenApiController;
use App\Http\Controllers\AuthApi\Core\RegistrationApiController;
use App\Http\Controllers\AuthApi\Core\RequestOtpApiController;
use App\Http\Controllers\AuthApi\Core\ResetPasswordApiController;
use App\Http\Controllers\AuthApi\Core\VerifyOtpApiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/ping-token', PingTokenApiController::class);
        Route::post('/logout', LogoutApiController::class);
        Route::post('/change-password', ChangePasswordApiController::class);
    });

    Route::post('/register', RegistrationApiController::class);
    Route::post('/login', LoginApiController::class);


    // Forgot Password
    Route::post("/request-otp", RequestOtpApiController::class);
    Route::post('/verify-otp', VerifyOtpApiController::class);
    Route::post('/reset-password', ResetPasswordApiController::class);
});
