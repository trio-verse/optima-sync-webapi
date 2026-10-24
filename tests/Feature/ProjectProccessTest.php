<?php

use App\Models\Client;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectVersion;
use App\Models\User;
use App\Services\ProjectManagment\ProjectVersionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('inssure that adding new cost to the Project will recalculate the total_amount', function () {

    /** @var TestCase $this */
    Queue::fake();

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
    $version = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'created_by' => $owner->id,
    ]);
    $project->update(['current_version_id' => $version->id]);
    $oldTotalAmount = $project->total_amount;

    for ($i = 0; $i < 3; $i++) {
        $this->actingAs($owner, 'sanctum')
            ->withHeader('X-Organization-Id', (string) $organization->id)
            ->postJson("/api/v1/projects/{$project->id}/costs", [
                'name' => 'Test Cost '.$i,
                'description' => 'Test Description '.$i,
                'amount' => 100.00 + $i * 10,
            ])
            ->assertCreated();
    }

    $newTotalAmount = $project->fresh()->total_amount;
    expect($newTotalAmount)->toBeGreaterThan($oldTotalAmount);
});

test('inssure that deleting a new cost from the Project will recalculate the total_amount', function () {

    /** @var TestCase $this */
    Queue::fake();

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
    $version = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'created_by' => $owner->id,
    ]);
    $project->update(['current_version_id' => $version->id]);

    $response = $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/costs", [
            'name' => 'Test Cost ',
            'description' => 'Test Description ',
            'amount' => 100.00,
        ]);
    $cost = $response->json('data');

    $oldTotalAmount = $project->fresh()->total_amount;
    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->deleteJson("/api/v1/projects/{$project->id}/costs/{$cost['id']}")->assertOk();

    $newTotalAmount = $project->fresh()->total_amount;
    expect($newTotalAmount)->toBeLessThan($oldTotalAmount);
});

test('branching a project version preserves the frozen source and copies its features', function () {
    /** @var TestCase $this */
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
    $sourceVersion = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $sourceVersion->id]);

    ProjectFeature::factory()->create([
        'project_id' => $project->id,
        'project_version_id' => $sourceVersion->id,
        'name' => 'Original feature',
    ]);

    $newVersion = app(ProjectVersionService::class)->branchVersion($sourceVersion, [
        'title' => 'Updated version',
    ]);

    expect($sourceVersion->fresh()->freeze)->toBeTrue()
        ->and($sourceVersion->fresh()->features_snapshot)->toHaveCount(1)
        ->and($sourceVersion->fresh()->features)->toHaveCount(1)
        ->and($newVersion->features)->toHaveCount(1)
        ->and($newVersion->features->first()->name)->toBe('Original feature')
        ->and($project->fresh()->current_version_id)->toBe($newVersion->id);
});

test('adding employee to the project then freeze the version and adding new Employee to the Same Project', function () {

    /** @var TestCase $this */
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
    $sourceVersion = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $sourceVersion->id]);

    $emp1 = Employee::create([
        'name' => 'Qusay 1',
        'organization_id' => $organization->id,
        'email' => 'qusay@gmail.com',
        'phone' => '0936362738',
        'position' => 'Developer',
        'cost_per_hour' => 20,
        'houres_per_point' => 2,
    ]);

    // Add employee to the project
    $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/employees", [
            'employee_id' => $emp1->id,
            'total_points' => 100,
        ]);

    // branch new version and freeze the old version
    $newVersion = app(ProjectVersionService::class)->branchVersion($sourceVersion, [
        'title' => 'Updated version',
    ]);

    $emp2 = Employee::create([
        'name' => 'DODO',
        'organization_id' => $organization->id,
        'email' => 'dodo@gmail.com',
        'phone' => '09363336278',
        'position' => 'Developer',
        'cost_per_hour' => 18,
        'houres_per_point' => 2,

    ]);

    $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/employees", [
            'employee_id' => $emp2->id,
            'total_points' => 80,
        ]);

    expect($sourceVersion->fresh()->freeze)->toBeTrue()
        ->and($sourceVersion->fresh()->employees_snapshot)->toHaveCount(1)
        ->and($newVersion->freeze)->toBeFalse()
        ->and($newVersion->fresh()->employees_snapshot)->toBeNull()
        ->and($project->fresh()->employees)->toHaveCount(2)
        ->and($project->fresh()->employees->first()->name)->toBe('Qusay 1')
        ->and($project->fresh()->current_version_id)->toBe($newVersion->id);
});

test('View pdf for the target version', function () {

    /** @var TestCase $this */
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
    // add version
    $sourceVersion = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $sourceVersion->id]);

    // Make employee
    $emp1 = Employee::create([
        'name' => 'Qusay 1',
        'organization_id' => $organization->id,
        'email' => 'qusay@gmail.com',
        'phone' => '0936362738',
        'position' => 'Developer',
        'cost_per_hour' => 20,
        'houres_per_point' => 2,
    ]);

    // Add employee to the project
    $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/employees", [
            'employee_id' => $emp1->id,
            'total_points' => 100,
        ]);

    // add cost to the Project
    $response = $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/costs", [
            'name' => 'Test Cost ',
            'description' => 'Test Description ',
            'amount' => 100.00,
        ]);

    // add feature
    ProjectFeature::factory()->create([
        'project_id' => $project->id,
        'project_version_id' => $sourceVersion->id,
        'name' => 'Original feature',
    ]);

    $response = $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->get("api/v1/projects/{$project->id}/versions/{$sourceVersion->id}/quotations/preview")
        ->assertOk();
    $data = $response->json('data');

    expect($data['data'])->toBeGreaterThan(1);

});



test('mutating a frozen project version branches an editable version', function () {

    /** @var TestCase $this */
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
    $sourceVersion = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $sourceVersion->id]);

    // Freeze the source version before attempting further mutations.
    $freezeResult = app(ProjectVersionService::class)->generateFreezedVersion($sourceVersion);

    expect($freezeResult['success'])->toBeTrue()
        ->and($project->fresh()->currentVersion->freeze)->toBeTrue();

    // trying to update the freeze project
    $member = User::factory()->create();
    DB::table('organization_members')->insert([
        'organization_id' => $organization->id,
        'user_id' => $member->id,
        'role' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Adding a feature after freezing must branch the version.
    $this->actingAs($owner, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/features", [
            'name' => 'feature 1',
        ])->assertCreated()
        ->assertJsonPath('version_branched', true);

    // A second mutation must use the same editable branched version.
    $this->actingAs($member, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/costs", [
            'name' => 'Test Cost ',
            'description' => 'Test Description ',
            'amount' => 100.00,
        ])->assertCreated()
        ->assertJsonMissingPath('version_branched');

    $project = $project->fresh(['currentVersion', 'versions', 'features', 'costs']);

    expect($project->currentVersion->freeze)->toBeFalse()
        ->and($project->fresh()->versions)->toHaveCount(2)
        ->and($project->currentVersion->based_on_version_id)->toBe($sourceVersion->id)
        ->and($project->features)->toHaveCount(1)
        ->and($project->costs)->toHaveCount(1);
});

test('owner can freeze a project version and persist quotation data and snapshots', function () {

    /** @var TestCase $this */
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
    $version = ProjectVersion::factory()->create([
        'project_id' => $project->id,
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $version->id]);
    ProjectFeature::factory()->create([
        'project_id' => $project->id,
        'project_version_id' => $version->id,
        'name' => 'Feature to snapshot',
    ]);

    $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/costs", [
            'name' => 'Cost to snapshot',
            'description' => 'Cost description',
            'amount' => 100,
        ])
        ->assertCreated();

    $response = $this->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/versions/{$version->id}/freeze")
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $version->id)
        ->assertJsonPath('data.freeze', true);

    $frozenVersion = $version->fresh();

    expect($frozenVersion->freeze)->toBeTrue()
        ->and($frozenVersion->features_snapshot)->toHaveCount(1)
        ->and($frozenVersion->features_snapshot[0]['name'])->toBe('Feature to snapshot')
        ->and($frozenVersion->costs_snapshot)->toHaveCount(1)
        ->and($frozenVersion->costs_snapshot[0]['name'])->toBe('Cost to snapshot')
        ->and($frozenVersion->employees_snapshot)->toBeArray()
        ->and($frozenVersion->quotation_data)->toBeArray()
        ->and($frozenVersion->quotation_data)->toHaveKeys([
            'quo_number',
            'project_features',
            'costs',
            'total',
        ])
        ->and($frozenVersion->quotation_data['project_features'])->toHaveCount(1)
        ->and($frozenVersion->quotation_data['costs'])->toHaveCount(1)
        ->and($frozenVersion->quotation_number)->toBe($frozenVersion->quotation_data['quo_number'])
        ->and($frozenVersion->quotation_generated_at)->not->toBeNull();
});

test('user without project organization access cannot freeze a project version', function () {

    /** @var TestCase $this */
    $owner = User::factory()->create();
    $outsider = User::factory()->create();
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
        'version_number' => 1,
        'created_by' => $owner->id,
        'freeze' => false,
    ]);
    $project->update(['current_version_id' => $version->id]);

    $this->actingAs($outsider, 'sanctum')
        ->withHeader('X-Organization-Id', (string) $organization->id)
        ->postJson("/api/v1/projects/{$project->id}/versions/{$version->id}/freeze")
        ->assertForbidden();

    expect($version->fresh()->freeze)->toBeFalse()
        ->and($version->fresh()->quotation_data)->toBeNull()
        ->and($version->fresh()->features_snapshot)->toBeNull()
        ->and($version->fresh()->costs_snapshot)->toBeNull();
});
