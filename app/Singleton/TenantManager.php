<?php

namespace App\Singleton;

class TenantManager
{
    protected ?int $organization_id;
    public function setOrganizationId(int $id): void
    {
        $this->organization_id = $id;
    }

    public function getOrganizationId(): ?int
    {
        return $this->organization_id;
    }

    public function hasOrganizationId(): bool
    {
        return !is_null($this->organization_id);
    }
}