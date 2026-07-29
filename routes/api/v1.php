<?php

use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\OrganizationLogoController;
use App\Http\Controllers\Api\V1\OtpAuthenticationController;
use App\Http\Controllers\Api\V1\UploadController;
use App\Http\Controllers\Api\V1\CityController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Otp Authentication Routes
    Route::post('/register-email', [OtpAuthenticationController::class, 'store']);
    Route::post('verify-otp', [OtpAuthenticationController::class, 'verify']);

    // Organization
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/organizations', [OrganizationController::class, 'index']);

        Route::post('/organizations', [OrganizationController::class, 'store']);
        Route::patch('/organizations/{id}', [OrganizationController::class, 'update']);
        Route::get('/organizations/{id}', [OrganizationController::class, 'show']);

        // Org members
        Route::post('/organizations/{organizationId}/members', [OrganizationController::class, 'addMember']);
        Route::patch('/organizations/{organizationId}/members/{memberId}', [OrganizationController::class, 'updateMemberRole']);

        // Organization Logo
        Route::post('/organizations/{organization}/logo', [OrganizationLogoController::class, 'store'])
            ->name('organizations.logo.store');

        //City
        Route::post('/city', [CityController::class, 'store']);

        //
        Route::patch('/city/{city}', [CityController::class, 'update']);
    });
});
