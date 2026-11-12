<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\IndexWorkspaceRequest;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Http\Resources\V1\Workspace\WorkspaceResource;
use App\Models\WorksapceModels\Workspace;
use App\Services\Workspace\WorkspaceService;
use Illuminate\Support\Facades\Log;

/**
 * @group Workspaces
 */
class WorkspaceController extends Controller
{
    public function __construct(private readonly WorkspaceService $workspaceService) {}

    /**
     * Display Workspaces.
     */
    public function index(IndexWorkspaceRequest $request)
    {
        $this->authorize('viewAny' , Workspace::class);
  
        $workspaces = $this->workspaceService->list($request->user(), $request->validated());

        return ApiResponse::pagination(
            WorkspaceResource::collection($workspaces),
            'Workspaces retrieved successfully'
        );
    }

    /**
     * Store Workspace.
     */
    public function store(StoreWorkspaceRequest $request)
    {
        $this->authorize('create', Workspace::class);
        $workspace = $this->workspaceService->create($request->validated());

        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace created successfully',
            201
        );
    }

    /**
     * Display Workspace.
     */
    public function show(Workspace $workspace)
    {
        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace retrieved successfully'
        );
    }

    /**
     * Update Workspace.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        $this->authorize('update', $workspace);

        $workspace = $this->workspaceService->update($workspace, $request->validated());

        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace updated successfully'
        );
    }

    /**
     * Remove Workspace.
     */
    public function destroy(Workspace $workspace)
    {
        $this->authorize('delete', $workspace);
        $this->workspaceService->delete($workspace);

        return ApiResponse::success(null, 'Workspace deleted successfully');
    }
}
