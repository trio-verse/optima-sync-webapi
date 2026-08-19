<?php

namespace App\Models;

use App\QueriesBuilder\CampaignQuery;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /** @use HasFactory<\Database\Factories\CampainFactory> */
    use HasFactory, BelongsToOrganization;

    public function newEloquentBuilder($query): CampaignQuery
    {
        return new CampaignQuery($query);
    }
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'expected_budget',
        'estimated_content_count',
        'status',
        'organization_id',
        'target'
    ];


    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'expected_budget' => 'decimal:2',
            'estimated_content_count' => 'integer',
        ];
    }

    protected $appends = [
        'duration',
        'content_progress',
        'content_performance',
        'is_overdue',
        'days_remaining',
        'formatted_budget',
    ];
    protected $hidden = [
        'organization_id',
    ];


    /**
     * [[[[[[[[[[[[[[[[[[[[[  Relations  ]]]]]]]]]]]]]]]]]]]]]]
     */

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }



    /**
     * Helpers / Attributes
     * @return int|null
     */
    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        $start = new \DateTime($this->start_date);
        $end = new \DateTime($this->end_date);
        $interval = $start->diff($end);
        return $interval->days + 1; // +1 to include both start and end date
    }
    public function getContentProgressAttribute()
    {
        $totalContents = $this->estimated_content_count;
        if ($totalContents <= 0) {
            return 0;
        }

        $completedContents = $this->contents()->where('status', 'completed')->count();
        return ($completedContents / $totalContents) * 100;
    }
    public function getContentPerformanceAttribute()
    {
        $duration = $this->duration;
        $progress = $this->content_progress;

        if ($duration <= 0 || $progress <= 0) {
            return 0;
        }

        // Simple performance calculation: progress divided by duration (in days)
        return $progress / $duration;
    }
    public function getIsOverdueAttribute()
    {
        if ($this->end_date && $this->status !== 'completed') {
            return now()->date > $this->end_date->date;
        }
        return false;
    }
    public function getDaysRemainingAttribute()
    {
        if (!$this->end_date || $this->status === 'completed') {
            return 0;
        }

        $remaining = now()->diffInDays($this->end_date, false);
        return $remaining < 0 ? 0 : $remaining;
    }
    public function getFormattedBudgetAttribute()
    {
        return 'USD ' . number_format((float) $this->expected_budget, 2);
    }

    // public function getStatisticsAttribute()
    // {
    //     $totalContents = $this->contents()->count();
    //     $completedContents = $this->contents()->where('status', 'completed')->count();
    //     $inProgressContents = $this->contents()->where('status', 'in_progress')->count();
    //     $pendingContents = $this->contents()->where('status', 'pending')->count();

    //     return [
    //         'total_contents' => $totalContents,
    //         'completed_contents' => $completedContents,
    //         'in_progress_contents' => $inProgressContents,
    //         'pending_contents' => $pendingContents,
    //         'completion_rate' => $totalContents > 0 ? ($completedContents / $totalContents) * 100 : 0,
    //     ];
    // }

    // public function getFormattedDatesAttribute()
    // {
    //     return [
    //         'start_date' => $this->start_date?->format('M j, Y'),
    //         'end_date' => $this->end_date?->format('M j, Y'),
    //         'created_at' => $this->created_at->format('M j, Y g:i A'),
    //         'updated_at' => $this->updated_at->format('M j, Y g:i A'),
    //     ];
    // }
}
