<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectMeeting\StoreProjectMeetingRequest;
use App\Http\Requests\ProjectMeeting\UpdateProjectMeetingRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectMeetingResource;
use App\Models\Project;
use App\Models\ProjectMeeting;
use App\Services\ProjectManagment\ProjectMeetingService;
use Illuminate\Http\JsonResponse;

/**
 * @group Project Meetings
 *
 * APIs for registering and scheduling project meetings
 */
class ProjectMeetingController extends Controller
{
    public function __construct(
        protected ProjectMeetingService $service
    ) {
    }

    /**
     * Index project meetings
     */
    public function index(Project $project): JsonResponse
    {
        try {
            $meetings = $this->service->getProjectMeetings($project);

            return ApiResponse::success(
                ProjectMeetingResource::collection($meetings),
                'Project meetings retrieved successfully'
            );
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Store/schedule project meeting
     */
    public function store(StoreProjectMeetingRequest $request, Project $project): JsonResponse
    {
        try {
            $meeting = $this->service->createMeeting($project, $request->validated());

            return ApiResponse::success(
                new ProjectMeetingResource($meeting),
                'Project meeting scheduled successfully',
                201
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to schedule meeting: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Show project meeting details
     */
    public function show(Project $project, ProjectMeeting $meeting): JsonResponse
    {
        try {
            $meetingModel = $this->service->getMeeting($project, $meeting);

            return ApiResponse::success(
                new ProjectMeetingResource($meetingModel),
                'Project meeting details retrieved successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::notFound($e->getMessage());
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Update project meeting
     */
    public function update(UpdateProjectMeetingRequest $request, Project $project, ProjectMeeting $meeting): JsonResponse
    {
        try {
            $updatedMeeting = $this->service->updateMeeting($project, $meeting, $request->validated());

            return ApiResponse::success(
                new ProjectMeetingResource($updatedMeeting),
                'Project meeting updated successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to update meeting: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Delete project meeting
     */
    public function destroy(Project $project, ProjectMeeting $meeting): JsonResponse
    {
        try {
            $this->service->deleteMeeting($project, $meeting);

            return ApiResponse::success([
                'id' => $meeting->id,
                'project_id' => $project->id,
                'deleted' => true,
            ], 'Project meeting deleted successfully');
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to delete meeting: ' . $th->getMessage(), 500);
        }
    }
}
