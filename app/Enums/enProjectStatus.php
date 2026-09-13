<?php

namespace App\Enums;

enum enProjectStatus: string
{

    case NEW = 'new';
    case UNDER_REVIEW = 'under_review';
    case ACCEPTED = 'accepted';
    case IN_PROGRESS = 'in_progress';
    case ON_HOLD = 'on_hold';
    case COMPLETED = 'completed';
    // when i canceld it 
    case REJECTED = 'rejected';
    // when the client cancelled it
    case FAIL = 'fail';
    
    case DELIVERD = 'deliverd';

    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}