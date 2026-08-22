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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

/**
 * @group Organizations
 */
class OrganizationController extends Controller
{
    public function __construct(private OrganizationService $organizationservice)
    {
    }

    /**
     * get all Organizations
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $orgs = Organization::withCount('members')->paginate((int)
                (request()->has('per_page') ? $request->input('per_page') : 15));

            return ApiResponse::pagination(OrganizationResource::collection($orgs));
        } catch (\Exception $e) {
            Log::error($e->getMessage() . 'code : ' . $e->getCode());
            return ApiResponse::serverError();
        }
    }



    /**
     * show the Organization
     * @param int $id
     * @return JsonResponse
     */
    public function show(string|int $id)
    {
        try {
            $org = $this->organizationservice->show($id);
            return ApiResponse::success(new OrganizationResource($org));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound("organization not found");
        } catch (\Exception $e) {
            Log::error($e->getMessage() . 'code : ' . $e->getCode());
            return ApiResponse::serverError($e->getMessage());
        }
    }
    /**
     * create organization
     *
     * this endpoint create new organization
     * response new organization
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        // $validatedData['user_id'] = $request->user()->id;
        $validatedData['user_id'] = $request->user()->id;


        try {
            $organization = $this->organizationservice->createOrganization(
                $validatedData,
            );
            return ApiResponse::response(new OrganizationResource($organization), 'The organization was created succsesfully', 201);
        } catch (\Exception $e) {
            Log::error("hellllo : " . $e->getMessage());
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
        } catch (ModelNotFoundException | RecordNotFoundException $e) {
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

            $isUpdated = $this->organizationservice->updateMemberRole(
                $organizationId,
                $memberId,
                $validatedData
            );

            if ($isUpdated)
                return ApiResponse::success([], 'The member role was updated successfully', 200);
            return ApiResponse::error([], 'Failed to update member role', 500);

        } catch (RecordNotFoundException | ModelNotFoundException $e) {
            return ApiResponse::error(null, "Organization or member not found", 404);
        }

    }

    /**
     * MyOrgs.
     * show a list of orginaztions that the user is a member of
     */

    public function getMyOrganizations(Request $request): JsonResponse
    {
        $user = request()->user();
        Gate::authorize('getMyOrganizations', Organization::class);

        $organizations = $this->organizationservice->getMyOrganizations($user, $request->input('per_page', 15));

        return ApiResponse::success(OrganizationResource::collection($organizations), 'The organizations were retrieved successfully', 200);
    }

    /**
     * get Members list
     * @param Request $request
     * @param string|int $organizationId
     * @return JsonResponse
     */
    public function getOrganizationMembers(Request $request, string|int $organizationId): JsonResponse
    {
        $members = $this->organizationservice->getOrganizationMembers($organizationId, $request->input('per_page', 15));
        return ApiResponse::pagination(OrganizationMemberResource::collection($members), 'The members were retrieved successfully', 200);
    }
}
