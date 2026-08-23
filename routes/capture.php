<?php

namespace Routes;

use App\Http\Controllers\Public\LeadCaptureController;
use Illuminate\Support\Facades\Route;

Route::prefix('capture')->group(function () {
    Route::get('/{token}', [LeadCaptureController::class, 'show']);
    Route::post('/{token}', [LeadCaptureController::class, 'store'])
        ->middleware('throttle:lead-capture');   
});
