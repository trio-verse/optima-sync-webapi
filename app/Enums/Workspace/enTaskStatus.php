<?php

namespace App\Enums\Workspace;


enum enTaskStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';


    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
