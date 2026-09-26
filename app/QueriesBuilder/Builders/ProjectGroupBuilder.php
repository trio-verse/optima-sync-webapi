<?php

namespace App\QueriesBuilder\Builders;

use App\QueriesBuilder\Dtos\QueryCondition;
use App\QueriesBuilder\Dtos\QueryGroup;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

final class ProjectGroupBuilder
{
    public function __construct(
        private ProjectConditionBuilder $conditionBuilder
    ) {
    }

    public function build(QueryGroup $group, Builder $query): Builder
    {
        return $this->buildGroup(
            group: $group,
            query: $query,
            isRoot: true
        );
    }

    private function buildGroup(
        QueryGroup $group,
        Builder $query,
        bool $isRoot = false
    ): Builder {
        if ($isRoot) {
            return $this->buildGroupConditions(
                $group,
                $query
            );
        }

        return match ($group->logic) {
            'and' => $query->where(
                fn(Builder $query) =>
                $this->buildGroupConditions(
                    $group,
                    $query
                )
            ),

            'or' => $query->orWhere(
                fn(Builder $query) =>
                $this->buildGroupConditions(
                    $group,
                    $query
                )
            ),

            default => throw new InvalidArgumentException(
                "Invalid logic '{$group->logic}'."
            ),
        };
    }

    private function buildGroupConditions(
        QueryGroup $group,
        Builder $query
    ): Builder {
        foreach ($group->conditions as $condition) {

            if ($condition instanceof QueryCondition) {
                $this->conditionBuilder->build(
                    $condition,
                    $query
                );

                continue;
            }

            if ($condition instanceof QueryGroup) {
                $this->buildGroup(
                    group: $condition,
                    query: $query
                );

                continue;
            }

            throw new InvalidArgumentException(
                'Invalid query node type.'
            );
        }

        return $query;
    }
}