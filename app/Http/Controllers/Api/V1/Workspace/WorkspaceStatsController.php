<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\WorksapceModels\Workspace;
use App\Services\Workspace\WorkspaceStatusService;
use Illuminate\Http\Request;

/**
 * @group Workspaces
 */
class WorkspaceStatsController extends Controller
{
    /**
     * Stats for Workspace.
     */
    public function __invoke(Request $request)
    {
        $this->authorize('viewAny', Workspace::class);

        $statusService = app(WorkspaceStatusService::class);
        $stats = $statusService->getAllStats();

        return ApiResponse::success($stats, 'Workspace stats retrieved successfully');
    }
}
