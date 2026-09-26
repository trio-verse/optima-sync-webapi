<?php

use App\QueriesBuilder\Builders\ProjectsQueryBuilder;
use App\QueriesBuilder\Dtos\QueryCondition;
use App\QueriesBuilder\Dtos\QueryDefinition;
use App\QueriesBuilder\Dtos\QueryGroup;
use Tests\TestCase;

uses(TestCase::class);

it('builds an eloquent query from a query definition', function () {
    config()->set('queryBuilderRegistry.projectManagement', [
        'name' => [
            'type' => 'string',
            'source' => 'column',
            'column' => 'name',
            'operators' => ['='],
        ],
        'client_name' => [
            'type' => 'string',
            'source' => 'relation_column',
            'relation' => 'client',
            'column' => 'name',
            'operators' => ['='],
        ],
    ]);

    $builder = new ProjectsQueryBuilder();

    $definition = new QueryDefinition(
        new QueryGroup('and', [
            new QueryCondition('name', '=', 'Website Redesign'),
            new QueryGroup('or', [
                new QueryCondition('client_name', '=', 'Acme Corp'),
            ]),
        ])
    );

    $query = $builder->build($definition);

    expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);

    $sql = $query->toSql();
    expect($sql)->toContain('"name" = ?')
        ->and($sql)->toContain('clients');
});
