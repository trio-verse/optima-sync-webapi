<?php

use App\QueriesBuilder\Builders\ProjectConditionBuilder;
use App\QueriesBuilder\Builders\ProjectGroupBuilder;
use App\QueriesBuilder\Builders\ProjectsQueryBuilder;
use App\QueriesBuilder\Mapper\ProjectQueryMapper;
use App\QueriesBuilder\Mapper\ProjectSemanticValidation;
use App\QueriesBuilder\Registries\ProjectQueryRegistry;
use App\Services\ProjectManagment\ProjectQueryService;
use Tests\TestCase;

uses(TestCase::class);

it('generates the exact query builder structure format required by the frontend', function () {
    config()->set('queryBuilderRegistry.projectManagement', [
        'industry' => [
            'label' => 'Industry',
            'type' => 'select',
            'source' => 'relation_column',
            'relation' => 'client',
            'column' => 'industry_id',
            'relation_path' => 'client.industry',
            'operators' => ['in', 'not_in'],
        ],
        'status' => [
            'label' => 'Status',
            'type' => 'select',
            'source' => 'column',
            'column' => 'status',
            'enum_class' => \App\Enums\enProjectStatus::class,
            'operators' => ['in', 'not_in'],
        ],
        'total_amount' => [
            'label' => 'Total Amount',
            'type' => 'number',
            'source' => 'column',
            'column' => 'total_amount',
            'operators' => ['=', '!=', '>', '>=', '<', '<=', 'between'],
        ],
    ]);

    $registry = new ProjectQueryRegistry();
    $service = new ProjectQueryService(
        new ProjectQueryMapper(),
        new ProjectSemanticValidation($registry),
        new ProjectsQueryBuilder(new ProjectGroupBuilder(new ProjectConditionBuilder($registry)))
    );

    $structure = $service->getQueryStructure();

    expect($structure)->toHaveKeys(['fields', 'logic_operators']);
    expect($structure['logic_operators'])->toHaveCount(2);

    $industryField = collect($structure['fields'])->firstWhere('key', 'industry');
    expect($industryField)->toMatchArray([
        'key' => 'industry',
        'label' => 'Industry',
        'type' => 'select',
    ]);
    expect($industryField['source']['type'])->toBe('relation');
    expect($industryField['source']['relation'])->toBe('client.industry');

    $statusField = collect($structure['fields'])->firstWhere('key', 'status');
    expect($statusField['source']['type'])->toBe('enum');
    expect($statusField['source']['options'])->toBeArray();
});

it('processes payload through mapper, validation, and query builder pipeline', function () {
    config()->set('queryBuilderRegistry.projectManagement', [
        'status' => [
            'label' => 'Status',
            'type' => 'select',
            'source' => 'column',
            'column' => 'status',
            'operators' => ['in', 'not_in'],
        ],
        'total_amount' => [
            'label' => 'Total Amount',
            'type' => 'number',
            'source' => 'column',
            'column' => 'total_amount',
            'operators' => ['=', '>', '<'],
        ],
    ]);

    $registry = new ProjectQueryRegistry();
    $service = new ProjectQueryService(
        new ProjectQueryMapper(),
        new ProjectSemanticValidation($registry),
        new ProjectsQueryBuilder(new ProjectGroupBuilder(new ProjectConditionBuilder($registry)))
    );

    $payload = [
        'query' => [
            'logic' => 'and',
            'conditions' => [
                [
                    'field' => 'status',
                    'operator' => 'in',
                    'value' => ['new', 'in_progress'],
                ],
                [
                    'field' => 'total_amount',
                    'operator' => '>',
                    'value' => 500,
                ],
            ],
        ],
    ];

    $query = $service->buildQueryFromPayload($payload);
    expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);

    $sql = strtolower($query->toSql());
    expect($sql)->toContain('"status" in (?, ?)')
        ->and($sql)->toContain('"total_amount" > ?');
});
