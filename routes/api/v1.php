<?php

use App\Http\Controllers\Api\V1\ChannelController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\IndustryController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\OrganizationLogoController;
use App\Http\Controllers\Api\V1\OtpAuthenticationController;
use App\Http\Controllers\Api\V1\UploadController;
use App\Models\User;
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
        Route::get('cities', [CityController::class, 'index']);
        Route::post('cities', [CityController::class, 'store']);
        Route::patch('cities/{city}', [CityController::class, 'update']);
        Route::delete('cities/{city}', [CityController::class, 'destroy']);

        //Channel
        Route::get('channels', [ChannelController::class, 'index']);
        Route::post('channels', [ChannelController::class, 'store']);
        Route::patch('channels/{channel}', [ChannelController::class, 'update']);
        Route::delete('channels/{channel}', [ChannelController::class, 'destroy']);

        // Industry
        Route::get('/industries', [IndustryController::class, 'index']);
        Route::post('/industries', [IndustryController::class, 'store']);
        Route::patch('/industries/{industry}', [IndustryController::class, 'update']);
        Route::delete('/industries/{industry}', [IndustryController::class, 'delete']);

        //Client
        Route::post('/clients', [ClientController::class, 'store']);
        Route::patch('/clients/{client}', [ClientController::class, 'update']);
        Route::get('/clients', [ClientController::class, 'index']);
    });
});
