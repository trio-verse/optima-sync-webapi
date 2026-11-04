<?php

namespace App\Http\Controllers\Api\V1\Workspace;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\Task\ChangeTaskPriorityRequest;
use App\Http\Requests\Workspace\Task\ChangeTaskStatusRequest;
use App\Http\Requests\Workspace\Task\StoreTaskRequest;
use App\Http\Requests\Workspace\Task\UpdateTaskRequest;
use App\Http\Resources\V1\Workspace\TaskResource;
use App\Models\Task;
use App\Services\Workspace\TaskService;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @group Task
 */
class TaskController extends Controller
{
    public function __construct(protected TaskService $task_service) {}

    /**
     * Display all tasks.
     * 
     * this endpoint display all tasks from DB
     * response get all tasks
     */
    public function index(Workspace $workspace)
    {
        $tasks = $this->task_service->getAllTasks($workspace);

        return ApiResponse::success(TaskResource::collection($tasks), 'tasks retrieved successfully');
    }



    /**
     * create task.
     * 
     * this endpoint create new task
     * response new task
     */
    public function store(StoreTaskRequest $request, Workspace $workspace)
    {

        $task = $this->task_service->create($workspace, $request->validated());

        return ApiResponse::response(new TaskResource($task), 'The task was created successfully', 201);
    }



    /**
     * Update task.
     * 
     * this endpoint update task data
     * response updated task data
     */
    public function update(UpdateTaskRequest $request,  Workspace $workspace, Task $task)
    {
        if ($task->workspace_id !== $workspace->id) {
            return ApiResponse::error([], 'This task does not belong to the workspace ', 403);
        }
        $is_updated = $this->task_service->update($workspace, $task, $request->validated());
        if ($is_updated) {
            return ApiResponse::response(new TaskResource($task), 'The task was updated successfully', 200);
        } else
            return ApiResponse::error(null, "bad request", 400);
    }

    /**
     * Delete task.
     * 
     * this endpoint delete task data from DB
     * response remove the specified task from DB
     */
    public function destroy(Workspace $workspace, Task $task)
    {
        $isDeleted = $this->task_service->delete($workspace->id, $task);
        if (!$isDeleted) {
            return ApiResponse::error([], 'deleting fail', 500);
        }

        return ApiResponse::success(
            [],
            'Task deleted successfully',
            200
        );
    }


    /**
     * Change task status.
     */
    public function changeStatus(ChangeTaskStatusRequest $request,  Workspace $workspace, Task $task)
    {
        try {
            $task = $this->task_service->changeStatusTask($workspace, $task, $request->validated('status'));
        } catch (AuthorizationException $e) {
            return ApiResponse::forbidden($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        }

        return ApiResponse::success(new TaskResource($task), 'Task status changed successfully');
    }

    /**
     * Change task priority.
     */

    public function changePriority(ChangeTaskPriorityRequest $request,  Workspace $workspace, Task $task)
    {
        try {
            $task = $this->task_service->changePriorityTask($workspace, $task, $request->validated('status'));
        } catch (AuthorizationException $e) {
            return ApiResponse::forbidden($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        }

        return ApiResponse::success(new TaskResource($task), 'Task priority changed successfully');
    }
}
