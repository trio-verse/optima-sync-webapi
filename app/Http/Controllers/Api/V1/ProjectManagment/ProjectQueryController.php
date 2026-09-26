<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Query\ProjectQueryRequest;
use App\Services\ProjectManagment\ProjectQueryService;

class ProjectQueryController extends Controller
{
    public function __construct(
        private readonly ProjectQueryService $projectQueryService
    ) {
    }

    /**
     * Get query structure for projects query builder
     */
    public function getQueryStructure()
    {
        try {
            $structure = $this->projectQueryService->getQueryStructure();

            return ApiResponse::success($structure, 'Query structure retrieved successfully');
        } catch (\Throwable $e) {
            return ApiResponse::error($e->getMessage(), 'Failed to retrieve query structure', 500);
        }
    }

    /**
     * Execute query and return paginated projects list
     */
    public function executeQuery(ProjectQueryRequest $request)
    {
        try {
            $validated = $request->validated();

            $projects = $this->projectQueryService->executeQuery(
                $validated,
                $validated['page'] ?? 1,
                $validated['per_page'] ?? 15
            );

            return ApiResponse::pagination($projects, 'Query executed successfully');
        } catch (\Throwable $e) {
            return ApiResponse::error($e->getMessage(), 'Failed to execute query', 500);
        }
    }

    /**
     * Execute analytics query (metrics and charts)
     */
    public function analytics(ProjectQueryRequest $request)
    {
        try {
            $validated = $request->validated();

            $result = $this->projectQueryService->executeAnalytics($validated);

            return ApiResponse::success($result, 'Analytics generated successfully');
        } catch (\Throwable $e) {
            return ApiResponse::error($e->getMessage(), 'Failed to generate analytics', 500);
        }
    }
}
