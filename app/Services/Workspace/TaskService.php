<?php

namespace App\Services\Workspace;

use App\Models\WorksapceModels\Task;
use App\Models\WorksapceModels\Workspace;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TaskService
{

    public function getAllTasks(Workspace $workspace): Collection
    {
        return Task::with('member')->where('workspace_id', $workspace->id)
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
