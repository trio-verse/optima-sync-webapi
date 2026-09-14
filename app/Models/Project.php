<?php

namespace App\Models;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'reference_id',
        'organization_id',
        'client_id',
        'current_version_id',
        'status',
        'created_by',
        'source',
        'sub_total',
        'profit_percentage',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'status' => enProjectStatus::class,
            'source' => enProjectSource::class,
            'sub_total' => 'decimal:2',
            'profit_percentage' => 'integer',
            'total_amount' => 'decimal:2',
        ];
    }

    protected $appends = [
        'active_version',
        'freeze_versions',
        'latest_version',
        'total_quotations',
        'total_value',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->reference_id = 'PRJ-' . str_pad(static::max('id') + 1, 4, '0', STR_PAD_LEFT);
            $project->created_by = auth()->id();
        });
    }

    /**
     * Relationships
     */

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function currentVersion(): BelongsTo
    {
        return $this->belongsTo(ProjectVersion::class, 'current_version_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ProjectVersion::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(ProjectCost::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(ProjectMeeting::class);
    }

    // public function quotations(): HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         Quotation::class,
    //         ProjectVersion::class,
    //         'project_id',
    //         'project_version_id',
    //         'id',
    //         'id'
    //     );
    // }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employees', 'project_id', 'employee_id')
            ->withPivot('total_points', 'organization_id')
            ->withTimestamps();
    }

    public function getTotalEmployeePointsAttribute(): int
    {
        return (int) $this->employees->sum('pivot.total_points');
    }

    public function getTotalEmployeeCostAttribute(): float
    {
        return (float) $this->employees->sum(function ($employee) {
            $points = (int) ($employee->pivot->total_points ?? 0);
            $hoursPerPoint = (int) ($employee->houres_per_point ?? 2);
            return $points * $hoursPerPoint * (float) $employee->cost_per_hour;
        });
    }

    /**
     * Helper Methods
     */
    public function calculateTotalCosts(): float
    {
        return (float) $this->costs->sum(
            fn(ProjectCost $cost) => $cost->quantity * $cost->amount
        );
    }
    public function getTotalCostsBudgetAttribute(): float
    {
        return $this->calculateTotalCosts();
    }

    public function getActiveVersionAttribute(): ?ProjectVersion
    {
        return $this->versions()->where('freeze', false)->first();
    }
    public function getFreezeVersionsAttribute(): ProjectVersion|Collection
    {
        return $this->versions()->where('freeze', true)->get();
    }

    public function getLatestVersionAttribute(): ?ProjectVersion
    {
        return $this->versions()->latest('version_number')->first();
    }

    public function getTotalQuotationsAttribute(): int
    {
        return $this->quotations()->count();
    }

    public function getTotalValueAttribute(): float
    {
        $latestQuotation = $this->quotations()->latest()->first();

        return $latestQuotation ? (float) $latestQuotation->total : 0;
    }
}
