<?php

namespace App\Services\ProjectManagment;

use App\Models\Project;
use App\Models\ProjectMeeting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectMeetingService
{
    /**
     * Get all meetings scheduled or recorded for a project.
     */
    public function getProjectMeetings(Project $project): Collection
    {
        return $project->meetings()
            ->orderBy('meeting_date', 'desc')
            ->get();
    }

    /**
     * Get a specific meeting ensuring it belongs to the project.
     */
    public function getMeeting(Project $project, ProjectMeeting|int $meeting): ProjectMeeting
    {
        $meetingModel = is_int($meeting)
            ? ProjectMeeting::find($meeting)
            : $meeting;

        if (!$meetingModel || $meetingModel->project_id !== $project->id) {
            throw new \DomainException('Meeting does not belong to the specified project.');
        }

        return $meetingModel;
    }

    /**
     * Schedule or record a new project meeting.
     */
    public function createMeeting(Project $project, array $data): ProjectMeeting
    {
        return DB::transaction(function () use ($project, $data) {
            $data['project_id'] = $project->id;
            $data['organization_id'] = $project->organization_id;
            $data['created_by'] = auth()->id();

            return $project->meetings()->create($data);
        });
    }

    /**
     * Update an existing project meeting.
     */
    public function updateMeeting(Project $project, ProjectMeeting|int $meeting, array $data): ProjectMeeting
    {
        $meetingModel = $this->getMeeting($project, $meeting);

        return DB::transaction(function () use ($meetingModel, $data) {
            $meetingModel->update($data);

            return $meetingModel->fresh();
        });
    }

    /**
     * Delete a project meeting.
     */
    public function deleteMeeting(Project $project, ProjectMeeting|int $meeting): bool
    {
        $meetingModel = $this->getMeeting($project, $meeting);

        return DB::transaction(function () use ($meetingModel) {
            return (bool) $meetingModel->delete();
        });
    }
}
