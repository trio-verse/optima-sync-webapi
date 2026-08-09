<?php

namespace App\Models\Scopes;

use App\Singleton\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrganizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $tenantManager = app(TenantManager::class);

        if ($tenantManager->hasOrganizationId()) {
            $builder->
                where($model->getTable() . '.organization_id',
                 $tenantManager->getOrganizationId());
        }
    }
}
