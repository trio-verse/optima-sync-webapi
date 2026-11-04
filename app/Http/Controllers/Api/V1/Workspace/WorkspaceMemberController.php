<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\Member\UpdateWorkspaceMemberRequest as MemberUpdateWorkspaceMemberRequest;
use App\Http\Requests\Workspace\members\StoreWorkspaceMemberRequest;
use App\Http\Requests\Workspace\members\UpdateWorkspaceMemberRequest;
use App\Models\WorkspaceMember;

class WorkspaceMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkspaceMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkspaceMember $workspaceMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkspaceMemberRequest $request, WorkspaceMember $workspaceMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkspaceMember $workspaceMember)
    {
        //
    }
}
