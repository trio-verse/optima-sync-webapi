<?php

use App\Http\Controllers\Api\V1\Workspace\TaskController;
use App\Http\Controllers\Api\V1\Workspace\WorkspaceController;
use App\Http\Controllers\Api\V1\Workspace\WorkspaceMemberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('workspaces', WorkspaceController::class);
Route::prefix('workspaces')->group(function () {
    Route::apiResource('{workspace}/members', WorkspaceMemberController::class)
        ->only(['index', 'store', 'destroy']);
    Route::apiResource('{workspace}/tasks', TaskController::class)->except(['show']);
    Route::post('{workspace}/tasks/{task}/change-status', [TaskController::class, 'changeStatus']);
    Route::post('{workspace}/tasks/{task}/change-priority', [TaskController::class, 'changePriority']);
});