<?php

namespace App\QueriesBuilder\Builders;

use App\Models\Project;
use App\QueriesBuilder\Dtos\QueryDefinition;
use App\QueriesBuilder\Registries\ProjectQueryRegistry;
use Illuminate\Database\Eloquent\Builder;

class ProjectsQueryBuilder
{
    private ProjectGroupBuilder $groupBuilder;

    public function __construct(?ProjectGroupBuilder $groupBuilder = null, ?ProjectQueryRegistry $registry = null)
    {
        $this->groupBuilder = $groupBuilder ?? new ProjectGroupBuilder(
            new ProjectConditionBuilder(
                $registry ?? new ProjectQueryRegistry()
            )
        );
    }

    public function build(QueryDefinition $definition, ?Builder $query = null): Builder
    {
        $query = $query ?? Project::query();

        return $this->groupBuilder->build($definition->query, $query);
    }
}

