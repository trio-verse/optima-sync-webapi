<?php

namespace App\QueriesBuilder\Dtos;

final readonly class QueryDefinition
{

    public function __construct(
        public QueryGroup $query
    ) {
    }
}
