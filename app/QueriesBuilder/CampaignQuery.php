<?php

namespace App\QueriesBuilder;

use Illuminate\Database\Eloquent\Builder;

class CampaignQuery extends Builder
{

    public function active(Builder $query)
    {
        return $query->where('status', 'active');
    }
    public function overdue(Builder $query)
    {
        return $query->where('end_date', '<', now())
            ->where('status', '!=', 'completed');
    }
    public function completed(Builder $query)
    {
        return $query->where('status', 'completed');
    }
    public function upcoming(Builder $query)
    {
        return $query->where('start_date', '>', now())
            ->where('status', '!=', 'completed');
    }
    public function filterByStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }

    public function search(Builder $query, string $search)
    {
        return $query->where(function (Builder $q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

}
