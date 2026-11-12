<?php

use App\Models\Organization;
use App\Models\User;
use App\Models\WorksapceModels\Workspace;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('organization owners can retrieve workspace statistics for their organization', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $foreignOwner = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $foreignOrganization = Organization::factory()->create(['user_id' => $foreignOwner->id]);

    $activeWorkspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Active workspace',
        'status' => 'active',
    ]);
    $completedWorkspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Completed workspace',
        'status' => 'complete',
    ]);
    $foreignWorkspace = Workspace::forceCreate([
        'organization_id' => $foreignOrganization->id,
        'name' => 'Foreign workspace',
        'status' => 'archived',
    ]);

    // add tasks to active workspaces
    $activeWorkspace->tasks()->create([
        'title' => 'Pending task',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);
    // add tasks to completed workspaces
    $completedWorkspace->tasks()->create([
        'title' => 'Completed task',
        'description' => 'Task description',
        'status' => 'completed',
        'priority' => 'medium',
    ]);

    // add tasks to archived workspaces from a different organization
    $foreignWorkspace->tasks()->create([
        'title' => 'Foreign task',
        'description' => 'Task description',
        'status' => 'completed',
        'priority' => 'medium',
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->getJson('/api/v1/workspaces/stats')
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Workspace stats retrieved successfully')
        ->assertJsonPath('data.all_tasks', 2)
        ->assertJsonPath('data.completed_tasks', 1)
        ->assertJsonPath('data.workspace_per_status.active', 1)
        ->assertJsonPath('data.workspace_per_status.complete', 1)
        ->assertJsonMissingPath('data.workspace_per_status.archived');
});
