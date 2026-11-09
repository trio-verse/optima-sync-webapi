<?php

use App\Models\Organization;
use App\Models\User;
use App\Models\WorksapceModels\Workspace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('organization members can be added, listed, and removed from a workspace', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", [
            'member_id' => $member->id,
        ])
        ->assertCreated()
        ->assertJsonPath('data.id', $member->id);

    $this->getJson("/api/v1/workspaces/{$workspace->id}/members")
        ->assertOk()
        ->assertJsonPath('data.0.id', $member->id);

    $workspaceMember = $workspace->workspaceMembers()->firstOrFail();

    $this->deleteJson("/api/v1/workspaces/{$workspace->id}/members/{$workspaceMember->id}")
        ->assertOk()
        ->assertJsonPath('message', 'Member removed successfully');

    expect($workspace->workspaceMembers()->count())->toBe(0);
});

test('a workspace member cannot be added twice', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $payload = ['member_id' => $member->id];

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", $payload)
        ->assertCreated();

    $this->postJson("/api/v1/workspaces/{$workspace->id}/members", $payload)
        ->assertUnprocessable();
});

// check the admin cann't add member from another org to th workspace 
test('a workspace member cannot be added from another organization', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization1 = Organization::factory()->create(['user_id' => $owner->id]);
    $organization2 = Organization::factory()->create(['user_id' => $member->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization1->id,
        'name' => 'Product workspace',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization2->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $payload = ['member_id' => $member->id];

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization1->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", $payload)
        // ->assertJsonPath('name', 'The selected user is not an accepted member or admin of this organization.');
        ->assertUnprocessable();
});

// check assign member to task from another org
test('can not assign member to task from another org', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization1 = Organization::factory()->create(['user_id' => $owner->id]);
    $organization2 = Organization::factory()->create(['user_id' => $member->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization1->id,
        'name' => 'Product workspace',
    ]);
    $task = $workspace->tasks()->create([
        'title' => 'Task 1',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization2->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $payload = ['member_id' => $member->id];

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization1->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/tasks/{$task->id}/assign-to-member", $payload)
        // ->assertJsonPath('name', 'The selected user is not an accepted member or admin of this organization.');
        ->assertUnprocessable();
});

// check assign member to task from out of the workspace
test('can not assign member to task from out of the workspace', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $member2 = User::factory()->create();
    $organization1 = Organization::factory()->create(['user_id' => $owner->id]);

    $workspace = Workspace::forceCreate([
        'organization_id' => $organization1->id,
        'name' => 'Product workspace',
    ]);
    $task = $workspace->tasks()->create([
        'title' => 'Task 1',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization1->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization1->id,
        'user_id' => $member2->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $payload = ['member_id' => $member->id];

    // add org Member to workspace
    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization1->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", $payload)
        ->assertCreated();

    // try to assign member to task that is not part of the workspace
    $payload2 = ['member_id' => $member2->id];
    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization1->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/tasks/{$task->id}/assign-to-member", $payload2)
        ->assertUnprocessable();
});

// change workspace editing from admin only
test('can only edit workspace as admin', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization1 = Organization::factory()->create(['user_id' => $owner->id]);

    $workspace = Workspace::forceCreate([
        'organization_id' => $organization1->id,
        'name' => 'Product workspace',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization1->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization1->id)
        ->putJson("/api/v1/workspaces/{$workspace->id}", ['name' => 'Updated workspace name'])
        ->assertForbidden();
});

// workspace members can edit tasks
test('workspace members can edit tasks', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace',
    ]);
    $task = $workspace->tasks()->create([
        'title' => 'Task 1',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", [
            'member_id' => $member->id,
        ])
        ->assertCreated();

    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->putJson("/api/v1/workspaces/{$workspace->id}/tasks/{$task->id}", [
            'title' => 'Updated task title',
        ])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated task title');
});

// workspace members can delete tasks
test('workspace members can delete tasks', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace',
    ]);
    $task = $workspace->tasks()->create([
        'title' => 'Task 1',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", [
            'member_id' => $member->id,
        ])
        ->assertCreated();

    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->deleteJson("/api/v1/workspaces/{$workspace->id}/tasks/{$task->id}")
        ->assertOk();
});

// workspace members can Store tasks
test('workspace members can Store tasks', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace',
    ]);
    $task = $workspace->tasks()->create([
        'title' => 'Task 1',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'medium',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/members", [
            'member_id' => $member->id,
        ])
        ->assertCreated();



    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace->id}/tasks", [
            'title' => 'Task 1',
            'description' => 'Task description',
            'priority' => 'medium',
        ])
        ->assertCreated();
});

// the normal member can see only the workspaces that he is a member of and not the other workspaces
test('workspace members can only see the workspaces they are members of', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $workspace1 = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace 1',
    ]);
    $workspace2 = Workspace::forceCreate([
        'organization_id' => $organization->id,
        'name' => 'Product workspace 2',
    ]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // add member to workspace1
    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/workspaces/{$workspace1->id}/members", [
            'member_id' => $member->id,
        ])
        ->assertCreated();

    // check that the member can see only workspace1 and not workspace2
    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->getJson("/api/v1/workspaces")
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $workspace1->id);
});