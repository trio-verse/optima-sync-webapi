<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\Members\StoreWorkspaceMemberRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\WorksapceModels\Workspace;
use App\Models\WorksapceModels\WorkspaceMember;
use App\Services\Workspace\WorkspaceMemberService;

class WorkspaceMemberController extends Controller
{
    public function __construct(private readonly WorkspaceMemberService $memberService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Workspace $workspace)
    {
        $members = $this->memberService->getAllMembers($workspace);

        return ApiResponse::success(UserResource::collection($members), 'Members retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkspaceMemberRequest $request, Workspace $workspace)
    {
        $member = $this->memberService->addMember($workspace, (int) $request->validated('member_id'));

        return ApiResponse::success(
            new UserResource($member->member),
            'Member added successfully',
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace, WorkspaceMember $member)
    {
        $this->memberService->delete($workspace, $member);

        return ApiResponse::success([], 'Member removed successfully');
    }
}
