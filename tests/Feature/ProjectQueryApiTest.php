<?php

use App\Models\Organization;
use App\Models\User;

it('returns query builder structure matching required specification', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user, 'sanctum')
        ->withHeaders(['X-Organization-Id' => $organization->id])
        ->getJson('/api/v1/projects/query-builder');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'fields',
                'logic_operators',
            ],
        ]);

    $data = $response->json('data');
    expect($data['fields'])->toBeArray()
        ->and($data['logic_operators'])->toHaveCount(2);

    $keys = array_column($data['fields'], 'key');
    expect($keys)->toContain('industry', 'status', 'total_amount', 'profit_percentage', 'source', 'issue_date');
});

it('executes analytics query pipeline end-to-end', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $user->id]);

    $payload = [
        'query' => [
            'logic' => 'and',
            'conditions' => [
                [
                    'field' => 'status',
                    'operator' => 'in',
                    'value' => ['new', 'in_progress', 'completed'],
                ],
            ],
        ],
        'metrics' => [
            'total_projects',
            'total_revenue',
            'average_profit_margin',
            'rejection_rate',
        ],
        'charts' => [
            'revenue_by_industry',
            'projects_by_status',
            'delivered_by_industry',
        ],
    ];

    $response = $this->actingAs($user, 'sanctum')
        ->withHeaders(['X-Organization-Id' => $organization->id])
        ->postJson('/api/v1/projects/analytics', $payload);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'metrics' => [
                    'total_projects',
                    'total_revenue',
                    'average_profit_margin',
                    'rejection_rate',
                ],
                'charts' => [
                    'revenue_by_industry',
                    'projects_by_status',
                    'delivered_by_industry',
                ],
            ],
        ]);
});

it('executes filtered projects query end-to-end', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $user->id]);

    $payload = [
        'query' => [
            'logic' => 'and',
            'conditions' => [
                [
                    'field' => 'total_amount',
                    'operator' => '>',
                    'value' => 100,
                ],
            ],
        ],
        'page' => 1,
        'per_page' => 10,
    ];

    $response = $this->actingAs($user, 'sanctum')
        ->withHeaders(['X-Organization-Id' => $organization->id])
        ->postJson('/api/v1/projects/query', $payload);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'meta',
        ]);
});
