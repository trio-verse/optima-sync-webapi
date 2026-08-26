<?php

declare(strict_types=1);

namespace App\Domain\Content;

use App\Models\Content;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Confirms the cost of a Content entity.
 *
 * An admin either accepts the currently stored cost as-is (by passing no
 * cost) or replaces it with a new value, after which the confirmation
 * metadata (`cost_confirmed_by`, `cost_confirmed_at`) is stamped.
 */
final class ContentCostConfirmer
{
    /**
     * @throws ValidationException
     */
    public function confirm(Content $content, User $confirmedBy, int|float|string|null $cost = null): Content
    {
        $finalCost = $cost ?? $content->cost;

        if ($finalCost === null || (float) $finalCost <= 0) {
            throw ValidationException::withMessages([
                'cost' => 'A cost greater than zero is required before it can be confirmed.',
            ]);
        }

        $content->update([
            'cost' => (float) $finalCost,
            'cost_confirmed_by' => $confirmedBy->id,
            'cost_confirmed_at' => Carbon::now(),
        ]);

        return $content->refresh();
    }
}
