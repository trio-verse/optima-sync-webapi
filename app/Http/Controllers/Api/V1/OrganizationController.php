<?php

namespace App\Http\Controllers;

use App\Helper\V1\ApiResponse;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class OrganizationController extends Controller
{
    public function __construct(private OrganizationService $organizationService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        try {
            $organization = $this->organizationService->createOrganization(
                $request->validated()
            );
            return ApiResponse::response($organization, 'The organization was created succsesfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 400);
        }

    }

    public function update(UpdateOrganizationRequest $request, int $id): JsonResponse
    {
        try {
            $organization = $this->organizationService->updateOrg(
                $id,
                $request->validated()
            );
            return ApiResponse::response($organization, 'The organization was updated succsesfully', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error(null, "organization not found", 404);
        } catch (\Exception $e) {
            return ApiResponse::error(null, "server error", 500);
        }

    }
}
