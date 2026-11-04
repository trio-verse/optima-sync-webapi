<?php

use App\Http\Controllers\Api\V1\Workspace\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('workspaces', WorkspaceController::class);
