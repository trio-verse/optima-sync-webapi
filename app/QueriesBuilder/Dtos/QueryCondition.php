<?php

namespace App\QueriesBuilder\Dtos;

final readonly class QueryCondition
{

    public function __construct(
        public string $field,
        public string $operator,
        public  mixed $value
    ) {
    }

}
