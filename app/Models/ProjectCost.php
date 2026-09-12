<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_version_id',
        'name',
        'description',
        'quantity',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'amount' => 'decimal:2',
        ];
    }

    protected $appends = [
        'line_total',
        'formatted_amount',
        'formatted_line_total'
    ];

    /**
     * Relationships
     */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // public function projectVersion(): BelongsTo
    // {
    //     return $this->belongsTo(ProjectVersion::class);
    // }

    /**
     * Helper Methods
     */

    public function getLineTotalAttribute(): float
    {
        return (float) $this->quantity * (float) $this->amount;
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format((float) $this->amount, 2);
    }

    public function getFormattedLineTotalAttribute(): string
    {
        return number_format($this->line_total, 2);
    }
}
