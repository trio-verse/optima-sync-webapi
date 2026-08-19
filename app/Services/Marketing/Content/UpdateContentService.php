<?php

declare(strict_types=1);

namespace App\Services\Marketing\Content;

use App\Domain\Content\ContentMetadataResolver;
use App\Domain\Content\ContentTransitionMatrix;
use App\Enums\enContentStatus;
use App\Exceptions\Content\ContentNotInCampaignException;
use App\Exceptions\Content\InvalidContentStatusTransitionException;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Gate;

/**
 * Updates a Content row that belongs to a Campaign.
 */
final class UpdateContentService
{
    public function __construct(
        private readonly ContentMetadataResolver $metadata,
        private readonly ContentTransitionMatrix $transitions,
        private readonly TenantManager $tenantManager,
    ) {

    }

    /**
     * @throws ContentNotInCampaignException
     * @throws InvalidContentStatusTransitionException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user, Campaign $campaign, Content $content, array $data): Content
    {

        $this->assertBelongsToCampaign($campaign, $content);

        Gate::authorize('update', $content);

        $isAdmin = $this->isContentAdmin($user);
        $newStatus = $this->extractRequestedStatus($data);

        if ($newStatus !== null) {
            $this->assertValidTransition($content->status, $newStatus, $isAdmin);
        }

        $data = array_merge($data, $this->metadata->resolve(
            user: $user,
            isAdmin: $isAdmin,
            newStatus: $newStatus,
            payloadHasCost: $this->hasCost($data),
        ));

        $content->update($data);

        return $content->refresh();
    }

    private function assertBelongsToCampaign(Campaign $campaign, Content $content): void
    {
        if (!$campaign->contents()->whereKey($content->id)->exists()) {
            // throw new ContentNotInCampaignException($content, $campaign);
            throw new AuthenticationException("Content #{$content->id} does not belong to campaign #{$campaign->id}.");
        }
    }

    private function extractRequestedStatus(array $data): ?enContentStatus
    {
        if (empty($data['status'])) {
            return null;
        }

        return enContentStatus::from($data['status']);
    }

    private function assertValidTransition(enContentStatus $current, enContentStatus $target, bool $isAdmin): void
    {
        if ($current === $target) {
            throw new AuthenticationException("Content is already in the status: {$current->value}");
        }

        if (!$this->transitions->isAllowed($current, $target, $isAdmin)) {
            $role = $isAdmin ? 'an admin' : 'a member';

            throw new AuthenticationException("As {$role}, you cannot move content from {$current->value} to {$target->value}.");
        }
    }

    private function isContentAdmin(User $user): bool
    {
        return $user->is_admin
            || $user->createdOrganizations->contains($this->tenantManager->getOrganizationId());
    }

    private function hasCost(array $data): bool
    {
        return isset($data['cost']) && $data['cost'] > 0;
    }
}
