<?php

namespace App\QueriesBuilder\Builders;

use App\QueriesBuilder\Dtos\QueryCondition;
use App\QueriesBuilder\Registries\ProjectQueryRegistry;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

final class ProjectConditionBuilder
{
    public function __construct(
        private ProjectQueryRegistry $registry,
    ) {
    }

    public function build(QueryCondition $condition, Builder $query): Builder
    {
        $field = $this->registry->fields()[$condition->field]
            ?? throw new InvalidArgumentException(
                "Field '{$condition->field}' not found."
            );

        return match ($field['source']) {
            'column' => $this->buildColumn(
                $query,
                $field,
                $condition
            ),

            'relation_column' => $this->buildRelationColumn(
                $query,
                $field,
                $condition
            ),

            'relation_count' => $this->buildRelationCount(
                $query,
                $field,
                $condition
            ),

            default => throw new InvalidArgumentException(
                "Invalid source '{$field['source']}'."
            ),
        };
    }

    private function buildColumn(Builder $query, array $field, QueryCondition $condition): Builder
    {
        return $this->applyOperator(
            $query,
            $field['column'],
            $condition->operator,
            $condition->value
        );
    }

    private function buildRelationColumn(Builder $query, array $field, QueryCondition $condition): Builder
    {
        return $query->whereHas(
            $field['relation'],
            function (Builder $relationQuery) use ($field, $condition) {
                $this->applyOperator(
                    $relationQuery,
                    $field['column'],
                    $condition->operator,
                    $condition->value
                );
            }
        );
    }

    private function buildRelationCount(Builder $query, array $field, QueryCondition $condition): Builder
    {
        $relation = $field['relation'];
        $countColumn = $relation . '_count';

        $query->withCount($relation);

        return $this->applyOperator(
            $query,
            $countColumn,
            $condition->operator,
            $condition->value
        );
    }

    private function applyOperator(Builder $query, string $column, string $operator, mixed $value): Builder
    {
        return match ($operator) {
            '=' => $query->where(
                $column,
                '=',
                $value
            ),

            '!=' => $query->where(
                $column,
                '!=',
                $value
            ),

            '>' => $query->where(
                $column,
                '>',
                $value
            ),

            '>=' => $query->where(
                $column,
                '>=',
                $value
            ),

            '<' => $query->where(
                $column,
                '<',
                $value
            ),

            '<=' => $query->where(
                $column,
                '<=',
                $value
            ),

            'between' => $query->whereBetween(
                $column,
                $value
            ),

            'in' => $query->whereIn(
                $column,
                $value
            ),

            'not_in' => $query->whereNotIn(
                $column,
                $value
            ),

            default => throw new InvalidArgumentException(
                "Invalid operator '{$operator}'."
            ),
        };
    }
}