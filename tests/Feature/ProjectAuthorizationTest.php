<?php

use App\Models\Client;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);


test('regular organization members can mutate projects', function () {
    /** @var \Tests\TestCase $this */


    $owner = User::factory()->create();
    $member = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $client = Client::factory()->create(['organization_id' => $organization->id]);
    $this->actingAs($owner, 'sanctum');
    $project = Project::factory()->create([
        'organization_id' => $organization->id,
        'client_id' => $client->id,
        'current_version_id' => null,
        'created_by' => $owner->id,
    ]);
    $version = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'created_by' => $owner->id,
    ]);
    $project->update(['current_version_id' => $version->id]);

    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'member',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->patchJson("/api/v1/projects/{$project->id}", [
            'payment_terms' => 'Immediate',
        ])
        ->assertOk();

    expect($project->fresh()->payment_terms)->toBe('Immediate');
});

test('organization owners can mutate their projects', function () {
    /** @var \Tests\TestCase $this */
    $owner = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $client = Client::factory()->create(['organization_id' => $organization->id]);
    $this->actingAs($owner, 'sanctum');
    $project = Project::factory()->create([
        'organization_id' => $organization->id,
        'client_id' => $client->id,
        'current_version_id' => null,
        'created_by' => $owner->id,
    ]);

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->patchJson("/api/v1/projects/{$project->id}", [
            'payment_terms' => 'Immediate',
        ])
        ->assertOk();

    expect($project->fresh()->payment_terms)->toBe('Immediate');
});

test('the user cann\'t access another Organization Project', function () {

    /** @var \Tests\TestCase $this */

    $owner = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $owner->id]);
    $client = Client::factory()->create(['organization_id' => $organization->id]);
    $this->actingAs($owner, 'sanctum');
    $project = Project::factory()->create([
        'organization_id' => $organization->id,
        'client_id' => $client->id,
        'current_version_id' => null,
        'created_by' => $owner->id,
    ]);

    $anotherUser = User::factory()->create();

    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->getJson("/api/v1/projects/{$project->id}")
        ->assertOk();

    $this->actingAs($anotherUser, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->getJson("/api/v1/projects/{$project->id}")
        ->assertForbidden();
});


