<?php

declare(strict_types=1);

namespace App\Services\Marketing\Content;

use App\Domain\Content\ContentMetadataResolver;
use App\Domain\Content\ContentTransitionMatrix;
use App\Enums\enContentStatus;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

/**
 * Changes the status of a Content row that belongs to a Campaign.
 * Enforces the role-based transition matrix and stamps the status
 * metadata through the domain resolvers.
 */
final class ChangeContentStatusService
{
    public function __construct(
        private readonly ContentMetadataResolver $metadata,
        private readonly ContentTransitionMatrix $transitions,
        private readonly TenantManager $tenantManager,
    ) {
    }

    /**
     * @throws AuthorizationException
     */
    public function changeStatus(User $user, Campaign $campaign, Content $content, string $status): Content
    {
        $this->assertBelongsToCampaign($campaign, $content);

        Gate::authorize('update', $content);

        $isAdmin = $this->isContentAdmin($user);
        $currentStatus = enContentStatus::from($content->status);
        $newStatus = enContentStatus::from($status);

        $this->assertValidTransition($currentStatus, $newStatus, $isAdmin);

        $data = array_merge(
            ['status' => $newStatus->value],
            $this->metadata->resolve(
                user: $user,
                isAdmin: $isAdmin,
                newStatus: $newStatus,
            ),
        );

        $content->update($data);

        return $content->refresh();
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

    /**
     * @throws AuthorizationException
     */
    private function assertValidTransition(enContentStatus $current, enContentStatus $target, bool $isAdmin): void
    {
        if (!$this->transitions->isAllowed($current, $target, $isAdmin)) {
            $role = $isAdmin ? 'an admin' : 'a member';

            throw new AuthorizationException("As {$role}, you cannot move content from {$current->value} to {$target->value}.");
        }
    }

    private function isContentAdmin(User $user): bool
    {
        return $user->is_admin
            || $user->createdOrganizations->contains($this->tenantManager->getOrganizationId());
    }
}
