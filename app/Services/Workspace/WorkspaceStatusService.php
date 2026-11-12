<?php

namespace App\Services\Workspace;

use App\Enums\Workspace\enTaskStatus;
use App\Models\WorksapceModels\Task;
use App\Models\WorksapceModels\Workspace;

class WorkspaceStatusService
{

    public function getAllStats(): array
    {
        $allTasks = Task::whereHas('workspace')->get(['id', 'status']);
        $completedTasks = $allTasks->where('status', enTaskStatus::COMPLETED->value)->count();
        $allTasksCount = $allTasks->count();

        $workspacePerStatus = Workspace::groupBy('status')
            ->selectRaw('status, COUNT(*) as count')
            ->pluck('count', 'status')
            ->toArray();
            
        return [
            'all_tasks' => $allTasksCount,
            'completed_tasks' => $completedTasks,

            'workspace_per_status' => $workspacePerStatus

        ];
    }
}
