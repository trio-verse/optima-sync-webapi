<?php

declare(strict_types=1);

namespace App\Services\Marketing\Content;

use App\Domain\Content\ContentCostConfirmer;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

/**
 * Confirms the cost of a Content row that belongs to a Campaign.
 * Admin-only action: accepts the current cost or replaces it before
 * stamping the confirmation metadata.
 */
final class ConfirmContentCostService
{
    public function __construct(
        private readonly ContentCostConfirmer $costConfirmer,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(User $user, Campaign $campaign, Content $content, array $data): Content
    {
        $this->assertBelongsToCampaign($campaign, $content);

        Gate::authorize('set_cost', $content);

        return $this->costConfirmer->confirm($content, $user, $data['cost'] ?? null);
    }

    /**
     * @throws AuthorizationException
     */
    private function assertBelongsToCampaign(Campaign $campaign, Content $content): void
    {
        if (!$campaign->contents()->whereKey($content->id)->exists()) {
            throw new AuthorizationException("Content #{$content->id} does not belong to campaign #{$campaign->id}.");
        }
    }
}
