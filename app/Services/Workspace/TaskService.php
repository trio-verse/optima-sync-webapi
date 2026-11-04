<?php

namespace App\Services\Workspace;

use App\Models\Task;
use App\Models\Workspace;
use App\Singleton\TenantManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TaskService
{

    public function getAllTasks(Workspace $workspace): Task
    {
        return Task::with('assignee')->where('workspace_id', $workspace->id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function create(Workspace $workspace, array $data): Task
    {

        // return Task::create($data);
        return $workspace->tasks()->create($data);
    }

    public function update(Task $task, array $data)
    {
        try {
            // return $task->update($data);
            return $task->updateOrFail($data);
        } catch (\Exception $e) {
            // Handle the exception, log it, or rethrow it as needed
            throw new ModelNotFoundException('Failed to update task: ' . $e->getMessage(), 0, $e);
        }
    }

    public function delete(int $workspace_id, Task $task): bool
    {
        if ($task->workspace_id !== $workspace_id) {
            return false;
        }
        return $task->delete();
    }


    public function changeStatusTask(Task $task, string $status): Task
    {
        $task->status = $status;
        $task->saveOrFail();

        return $task;
    }

    public function changePriorityTask(Task $task, string $priority): Task
    {
        $task->priority = $priority;
        $task->saveOrFail();

        return $task;
    }
}
