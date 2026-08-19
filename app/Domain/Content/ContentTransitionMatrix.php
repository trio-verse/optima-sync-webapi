<?php

declare(strict_types=1);

namespace App\Domain\Content;

use App\Enums\enContentStatus;

final class ContentTransitionMatrix
{
    /**
     * @var array<string, array{member: list<string>, admin: list<string>}>
     */
    private const TRANSITIONS = [
        enContentStatus::DRAFT->value => [
            'member' => [enContentStatus::IN_REVIEW->value],
            'admin' => [
                enContentStatus::IN_REVIEW->value,
                enContentStatus::APPROVED->value,
                enContentStatus::PUBLISHED->value,
            ],
        ],
        enContentStatus::IN_REVIEW->value => [
            'member' => [enContentStatus::DRAFT->value],
            'admin' => [
                enContentStatus::DRAFT->value,
                enContentStatus::APPROVED->value,
                enContentStatus::REJECTED->value,
                enContentStatus::PUBLISHED->value,
            ],
        ],
        enContentStatus::REJECTED->value => [
            'member' => [enContentStatus::DRAFT->value],
            'admin' => [
                enContentStatus::DRAFT->value,
                enContentStatus::IN_REVIEW->value,
                enContentStatus::APPROVED->value,
                enContentStatus::PUBLISHED->value,
            ],
        ],
        enContentStatus::APPROVED->value => [
            'member' => [enContentStatus::PUBLISHED->value],
            'admin' => [
                enContentStatus::PUBLISHED->value,
                enContentStatus::REJECTED->value,
                enContentStatus::DRAFT->value,
            ],
        ],
        enContentStatus::PUBLISHED->value => [
            'member' => [enContentStatus::DRAFT->value],
            'admin' => [enContentStatus::DRAFT->value],
        ],
    ];

    public function isAllowed(enContentStatus $from, enContentStatus $to, bool $isAdmin): bool
    {
        if ($from === $to) {
            return false;
        }

        $allowedTargets = self::TRANSITIONS[$from->value][$isAdmin ? 'admin' : 'member'] ?? [];

        return in_array($to->value, $allowedTargets, true);
    }
}
