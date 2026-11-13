<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\Members\StoreWorkspaceMemberRequest;
use App\Http\Resources\V1\OrganizationMemberResource;
use App\Models\WorksapceModels\Workspace;
use App\Models\WorksapceModels\WorkspaceMember;
use App\Services\Workspace\WorkspaceMemberService;

/**
 * @group Workspaces
 */
class WorkspaceMemberController extends Controller
{
    public function __construct(private readonly WorkspaceMemberService $memberService) {}

    /**
     * Display Workspace Members.
     */
    public function index(Workspace $workspace)
    {
        $members = $this->memberService->getAllMembers($workspace);

        return ApiResponse::success(OrganizationMemberResource::collection($members), 'Members retrieved successfully');
    }

    /**
     * Store Workspace Member.
     */
    public function store(StoreWorkspaceMemberRequest $request, Workspace $workspace)
    {
        $member = $this->memberService->addMember($workspace, (int) $request->validated('organization_member_id'));

        return ApiResponse::success(
            new OrganizationMemberResource($member->organizationMember->load('user')),
            'Member added successfully',
            201
        );
    }

    /**
     * Remove Workspace Member.
     */
    public function destroy(Workspace $workspace, WorkspaceMember $member)
    {
        $this->memberService->delete($workspace, $member);

        return ApiResponse::success([], 'Member removed successfully');
    }
}
