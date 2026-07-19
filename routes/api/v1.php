<?php

use App\Http\Controllers\Api\V1\OtpAuthenticationController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Otp Authentication Routes
    Route::post('/register-email', [OtpAuthenticationController::class, 'store']);
    Route::post('verify-otp', [OtpAuthenticationController::class, 'verify']);

    // create Organization 
    Route::post('/organizations' , [OrganizationController::class, 'store']);

});
