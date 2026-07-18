<?php

namespace App\Http\Controllers;

use App\Helper\V1\ApiResponse;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class OrganizationController extends Controller
{
    public function __construct(private OrganizationService $organizationservice)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        try {
            $organization  = $this->OrganizationService->createOrganization(
            $request->validated()
        );
        return ApiResponse::response( $organization , 'The organization was created succsesfully' , 201);
        } catch (\Exception $e) {
           return ApiResponse::error(null, $e->getMessage(), 400);
        }

    }
}
