<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use Illuminate\Database\RecordNotFoundException;

class OrganizationController extends Controller
{
    public function __construct(private OrganizationService $organizationservice)
    {
    }
 /**
     * create organization
     * 
     * this endpoint create new organization  
     * response new organization 
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        try {
            $organization  = $this->organizationservice->createOrganization(
            $request->validated()
        );
        return ApiResponse::response( $organization , 'The organization was created succsesfully' , 201);
        } catch (\Exception $e) {
           return ApiResponse::error(null, $e->getMessage(), 400);
        }

    }

    /**
     * Update organization
     * 
     * this endpoint update organization data 
     * response updated organization data
     */
       public function update(UpdateOrganizationRequest $request, int $id): JsonResponse
    {
        try {
            $organization = $this->organizationservice->updateOrg(
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
