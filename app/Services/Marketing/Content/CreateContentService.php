<?php

namespace App\Services\Marketing\Content;

use App\Enums\enContentStatus;
use App\Models\Content;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Validation\UnauthorizedException;

class CreateContentService
{
    /**
     * Create new content with appropriate status and metadata
     *
     * @throws UnauthorizedException
     */
    public function createContent(User $user, array $data): Content
    {
        if(isset($data['status']))
            $this->validateUserCanCreateContentWithStatus($user, $data['status']);
        else
            $data['status'] = enContentStatus::DRAFT->value;
        $this->applyContentMetadata($user, $data);

        return Content::create($data);
    }

    /**
     * Validate that user has permission to create content with the given status
     *
     * @throws UnauthorizedException
     */
    private function validateUserCanCreateContentWithStatus(User $user, string $status): void
    {
        $isAdmin = $this->isContentAdmin($user);
        $isMember = $user->is_member;

        match ($status) {
            enContentStatus::PUBLISHED->value => $isAdmin ?: throw new UnauthorizedException(
                'Only administrators can publish content directly.'
            ),
            enContentStatus::APPROVED->value => $isAdmin ?: throw new UnauthorizedException(
                'Only administrators can approve content.'
            ),
            enContentStatus::IN_REVIEW->value => $isMember ?: throw new UnauthorizedException(
                'Only members can submit content for review.'
            ),
            enContentStatus::DRAFT->value => true,
            default => throw new UnauthorizedException("Invalid content status: {$status}"),
        };
    }

    /**
     * Apply appropriate metadata based on user role and content status
     */
    private function applyContentMetadata(User $user, array &$data): void
    {
        $status = $data['status'] ;

        if ($this->isContentAdmin($user)) {
            $this->applyAdminMetadata($user, $data, $status);
        } elseif ($user->is_member && $status === enContentStatus::IN_REVIEW->value) {
            $this->applyMemberMetadata($user, $data);
        } elseif ($status === enContentStatus::DRAFT->value) {
            $this->applyDraftMetadata($user, $data);
        }
    }

    /**
     * Apply metadata for administrator-created content
     */
    private function applyAdminMetadata(User $user, array &$data, string $status): void
    {
        match ($status) {
            enContentStatus::PUBLISHED->value => $this->applyPublishedMetadata($user, $data),
            enContentStatus::APPROVED->value => $this->applyApprovedMetadata($user, $data),
            default => null,
        };
    }

    /**
     * Apply metadata for published content
     */
    private function applyPublishedMetadata(User $user, array &$data): void
    {
        $data['published_at'] = now();
        $data['published_by'] = $user->id;
        $data['approved_at'] = now();
        $data['assigned_by'] = $user->id;

        if ($this->hasCost($data)) {
            $data['cost_confirmed_by'] = $user->id;
            $data['cost_confirmed_at'] = now();
        }
    }

    /**
     * Apply metadata for approved content
     */
    private function applyApprovedMetadata(User $user, array &$data): void
    {
        $data['approved_at'] = now();
    }

    /**
     * Apply metadata for member-submitted content in review
     */
    private function applyMemberMetadata(User $user, array &$data): void
    {
        $data['assigned_by'] = $user->id;
    }

    /**
     * Apply metadata for draft content
     */
    private function applyDraftMetadata(User $user, array &$data): void
    {
        $data['assigned_by'] = $user->id;
    }

    /**
     * Check if user is a content administrator
     */
    private function isContentAdmin(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->createdOrganizations->contains(
            app(TenantManager::class)->getOrganizationId()
        );
    }

    /**
     * Check if content has an associated cost
     */
    private function hasCost(array $data): bool
    {
        return isset($data['cost']) && $data['cost'] > 0;
    }
}
