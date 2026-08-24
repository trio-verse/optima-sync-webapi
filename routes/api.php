<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['throttle:tiered-api'])->group(function () {
    require __DIR__ . '/api/v1.php';
});
require __DIR__ . '/capture.php';
