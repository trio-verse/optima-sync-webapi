<?php

declare(strict_types=1);

namespace App\Domain\Content;

use App\Enums\enContentStatus;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Decides which metadata fields get stamped onto a Content update, based on
 * who is acting and whether a status change is happening.
 *
 * Cost confirmation is intentionally not handled here — it is an explicit
 * admin action performed through ContentCostConfirmer.
 */
final class ContentMetadataResolver
{
    /**
     * @return array<string, mixed>
     */
    public function resolve(
        User $user,
        bool $isAdmin,
        ?enContentStatus $newStatus,
    ): array {
        $metadata = $newStatus !== null
            ? $this->metadataForStatus($newStatus, $user)
            : [];

        if (!$isAdmin && $this->isAuthoringStatus($newStatus)) {
            // Re-stamp ownership whenever a non-admin author drafts or
            // (re)submits content — mirrors the original behaviour.
            $metadata['assigned_by'] = $user->id;
        }

        return $metadata;
    }

    /**
     * @return array<string, mixed>
     */
    private function metadataForStatus(enContentStatus $status, User $user): array
    {
        return match ($status) {
            enContentStatus::PUBLISHED => [
                'published_at' => Carbon::now(),
                'published_by' => $user->id,
            ],
            enContentStatus::APPROVED => [
                'approved_at' => Carbon::now(),
            ],
            default => [],
        };
    }

    private function isAuthoringStatus(?enContentStatus $status): bool
    {
        return in_array($status, [enContentStatus::DRAFT, enContentStatus::IN_REVIEW], true);
    }
}
