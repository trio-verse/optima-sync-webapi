<?php

use App\Http\Controllers\Api\V1\CampaignController;
use App\Http\Controllers\Api\V1\ChannelController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\ConnectionController;
use App\Http\Controllers\Api\V1\ContentController;
use App\Http\Controllers\Api\V1\IndustryController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\OrganizationLogoController;
use App\Http\Controllers\Api\V1\OtpAuthenticationController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\StakeholderController;
use App\Http\Controllers\Api\V1\UploadController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Otp Authentication Routes
    Route::post('/register-email', [OtpAuthenticationController::class, 'store']);
    Route::post('verify-otp', [OtpAuthenticationController::class, 'verify']);

    Route::middleware(['auth:sanctum'])->group(function () {

        // organizations get
        Route::get('/organizations', [OrganizationController::class, 'index']);
        Route::get('/organizations/myOrgs', [OrganizationController::class, 'getMyOrganizations'])->name('myOrgs');
        Route::post('/organizations', [OrganizationController::class, 'store']);

        Route::middleware(['active_org'])->group(function () {
            // Organizations
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

            // connections
            Route::post('/clients/{client}/connections', [ConnectionController::class, 'store']);
            Route::get('/connections', [ConnectionController::class, 'index']);
            Route::get('/clients/{client}/connections', [ConnectionController::class, 'getClientConnections']);
            Route::get('connections/{connection}', [ConnectionController::class, 'show']);
            Route::patch('connections/{connection}', [ConnectionController::class, 'update']);
            Route::delete('connections/{connection}', [ConnectionController::class, 'destroy']);

            // Products
            Route::apiResource('products', ProductController::class);

            //Stakeholders
            Route::get('clients/{client}/stakeholders', [StakeholderController::class, 'index']);
            Route::post('clients/{client}/stakeholders', [StakeholderController::class, 'store']);
            Route::patch('clients/{client}/stakeholders/{stakeholder}', [StakeholderController::class, 'update']);
            Route::delete('clients/{client}/stakeholders/{stakeholder}', [StakeholderController::class, 'destroy']);
            // connection activities
            Route::get('connections/{connection}/activities', [ConnectionController::class, 'getActivities']);
            Route::post('connections/{connection}/activities', [ConnectionController::class, 'storeActivity']);

            // Campaigns
            Route::get('campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
            Route::post('campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
            Route::patch('campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
            Route::get('campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
            Route::delete('campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

            // contents
            Route::get('campaigns/{campaign}/contents', [ContentController::class, 'index'])->name('campaign.contents.index');
            Route::post('campaigns/{campaign}/contents', [ContentController::class, 'store'])->name('campaign.contents.store');
            Route::get('campaigns/{campaign}/contents/{content}', [ContentController::class, 'show'])->name('campaign.contents.show');
            Route::patch('campaigns/{campaign}/contents/{content}', [ContentController::class, 'update'])->name('campaign.contents.update');
            Route::delete('campaigns/{campaign}/contents/{content}', [ContentController::class, 'destroy'])->name('campaign.contents.destroy');
        });

    });
});
