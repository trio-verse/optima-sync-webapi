<?php

namespace App\Enums;

enum enTaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';


    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
