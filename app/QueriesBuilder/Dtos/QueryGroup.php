<?php

namespace App\QueriesBuilder\Dtos;

final readonly class QueryGroup
{
    /**
     * @param array<QueryCondition|QueryGroup> $conditions
     */
    public function __construct(
        public string $logic,
        // can contain both conditions and nested groups
        public array $conditions
    ) {
    }
}
