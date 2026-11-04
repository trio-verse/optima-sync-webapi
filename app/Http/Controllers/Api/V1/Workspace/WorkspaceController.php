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

/**
 * @group Workspaces
 */
class WorkspaceController extends Controller
{
    public function __construct(private readonly WorkspaceService $workspaceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexWorkspaceRequest $request)
    {
        $workspaces = $this->workspaceService->list($request->validated());

        return ApiResponse::pagination(
            WorkspaceResource::collection($workspaces),
            'Workspaces retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkspaceRequest $request)
    {
        $workspace = $this->workspaceService->create($request->validated());

        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        $workspace = $this->workspaceService->update($workspace, $request->validated());

        return ApiResponse::success(
            new WorkspaceResource($workspace),
            'Workspace updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace)
    {
        $this->workspaceService->delete($workspace);

        return ApiResponse::success(null, 'Workspace deleted successfully');
    }
}
