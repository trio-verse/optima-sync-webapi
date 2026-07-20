<?php

use App\Http\Controllers\Api\V1\OtpAuthenticationController;
use App\Http\Controllers\Api\V1\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Otp Authentication Routes
    Route::post('/register-email', [OtpAuthenticationController::class, 'store']);
    Route::post('verify-otp', [OtpAuthenticationController::class, 'verify']);

    // Organization
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('/organizations' , [OrganizationController::class, 'store']);
        Route::patch('/organizations/{id}' , [OrganizationController::class, 'update']);
    });

});
