<?php

namespace App\Rules;

use App\Models\Organization;
use App\Singleton\TenantManager;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class AcceptedOrganizationMember implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $organizationId = app(TenantManager::class)->getOrganizationId();

        if (!$organizationId) {
            $fail('The organization context is missing.');

            return;
        }

        $isAcceptedMember = DB::table('organization_members')
            ->where('organization_id', $organizationId)
            ->where('user_id', $value)
            ->whereIn('role', ['admin', 'member'])
            ->exists();

        $isAdmin = Organization::where('id', $organizationId)
            ->where('user_id', $value)
            ->exists();

        if (!$isAcceptedMember && !$isAdmin) {
            $fail('The selected user is not an accepted member or admin of this organization.');
        }
    }
}
