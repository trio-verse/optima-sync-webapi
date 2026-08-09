<?php

namespace App\Enums;

enum enConnectionStages: string
{
    case LEAD = 'lead';
    case CONECTED = 'conected';
    case MISSING_INFO = 'missing_info';
    case INTRESTED = 'intrested';
    case NOT_INTRESTED = 'not_intrested';
    case WIN = 'win';
    case CLOSED = 'closed';
 
    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
