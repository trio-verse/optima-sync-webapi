<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Requests\OrgMember\StoreOrganizationMemberRequest;
use App\Http\Requests\OrgMember\UpdateOrganizationMemberRoleRequest;
use App\Http\Resources\V1\OrganizationMemberResource;
use App\Http\Resources\V1\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
                $request->validated(),
            );
            return ApiResponse::response(new OrganizationResource($organization), 'The organization was created succsesfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 500);
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
            $validatedData = $request->validated();

            $validatedData['user_id'] = $request->user()->id;

            $organization = $this->organizationservice->updateOrg($id, $validatedData);
            return ApiResponse::response(new OrganizationResource($organization), 'The organization was updated succsesfully', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error(null, "organization not found", 404);
        } catch (AuthorizationException $e) {
            return ApiResponse::error(null, "Not allowed", 403);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }

    /**
     * Add member to organization
     *
     * this endpoint add new member to organization
     * response updated organization data
     */
    public function addMember(StoreOrganizationMemberRequest $request, int $organizationId): JsonResponse
    {
        try {
            $member = $this->organizationservice->addMember(
                $organizationId,
                $request->validated()
            );
            return ApiResponse::response(new OrganizationMemberResource($member), 'The member was added succsesfully', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error(null, "organization not found", 404);
        } catch (AuthorizationException $e) {
            return ApiResponse::error(null, "Not allowed", 403);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }

    /**
     * update member role in organization
     */
    public function updateMemberRole(UpdateOrganizationMemberRoleRequest $request, int $organizationId, int $memberId): JsonResponse
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();

            $member = $this->organizationservice->updateMemberRole(
                $organizationId,
                $memberId,
                $validatedData
            );

            return ApiResponse::response(new OrganizationMemberResource($member), 'The member role was updated successfully', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error(null, "Organization or member not found", 404);
        } catch (AuthorizationException $e) {
            return ApiResponse::error(null, "Not allowed", 403);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "Server error", 500);
        }
    }
}
