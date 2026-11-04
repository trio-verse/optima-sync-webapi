<?php

namespace App\Enums;

enum enWorkspaceStatus: string
{
    case ARCHIVED = 'archived';
    case ACTIVE = 'active';
    case COMPLETE = 'complete';
 
    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
