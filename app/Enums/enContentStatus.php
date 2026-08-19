<?php

namespace App\Enums;

enum enContentStatus: string
{
    case DRAFT = 'draft';
    case IN_REVIEW = 'in_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PUBLISHED = 'published';

    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
