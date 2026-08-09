<?php

namespace App\Trait;

use App\Models\Scopes\OrganizationScope;
use App\Singleton\TenantManager;

trait BelongsToOrganization
{
    protected static function bootBelongsToOrganization(): void
    {
        // 1. Add Global Scope for SELECT queries
        static::addGlobalScope(new OrganizationScope());

        // 2. Automatically assign organization_id on CREATE
        static::creating(function ($model) {
            $tenantManager = app(TenantManager::class);

            if ($tenantManager->hasOrganizationId() && empty($model->organization_id)) {
                $model->organization_id = $tenantManager->getOrganizationId();
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'organization_id');
    }
}
