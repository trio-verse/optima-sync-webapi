<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_version_id',
        'quotation_number',
        'issue_date',
        'valid_until',
        'subtotal',
        'discount',
        'tax',
        'total',
        'pdf_path',
        'created_by',
        'data',
        'payment_terms'
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'valid_until' => 'date',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'data'=> 'array'
        ];
    }

    /**
     * Relationships
     */

    public function projectVersion(): BelongsTo
    {
        return $this->belongsTo(ProjectVersion::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Helper Methods
     */

    protected static function booted()
    {
        static::creating(function (Quotation $quotation) {
            if (empty($quotation->quotation_number)) {
                $quotation->quotation_number = static::generateQuotationNumber();
            }
        });
    }

    public static function generateQuotationNumber(): string
    {
        $prefix = 'QTN';
        $datePart = date('Ym'); // e.g., 202406
        $pattern = "{$prefix}-{$datePart}-%";

        // adjust the format to simpler incremental, e.g., QTN-202406-5
        $lastNumber = static::where('quotation_number', 'like', $pattern)
            ->selectRaw("MAX(CAST(SUBSTRING_INDEX(quotation_number, '-', -1) AS UNSIGNED)) as max_number")
            ->value('max_number');

        $nextNumber = $lastNumber ? ($lastNumber + 1) : 1;

        return "{$prefix}-{$datePart}-{$nextNumber}";
    }

    public function calculateTotal(): array
    {
        $project = $this->projectVersion?->project;
        $projectSubTotal = (float) ($project->sub_total ?? 0);
        $projectProfitPercentage = (float) ($project->profit_percentage ?? 0);
        $projectTotalAmount = (float) ($project->total_amount ?? ($projectSubTotal * (1 + ($projectProfitPercentage / 100))));

        $subtotal = $projectTotalAmount > 0 ? $projectTotalAmount : $this->projectVersion?->calculateTotalCosts() ?? 0;
        $discount = (float) $this->discount;
        $tax = (float) $this->tax;
        $total = $subtotal - $discount + $tax;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    public function recalculateTotals(): bool
    {
        $totals = $this->calculateTotal();
        $this->subtotal = $totals['subtotal'];
        $this->total = $totals['total'];

        return $this->save();
    }

    public function isExpired(): bool
    {
        return $this->valid_until < now()->startOfDay();
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return number_format((float) $this->subtotal, 2);
    }

    public function getFormattedDiscountAttribute(): string
    {
        return number_format((float) $this->discount, 2);
    }

    public function getFormattedTaxAttribute(): string
    {
        return number_format((float) $this->tax, 2);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format((float) $this->total, 2);
    }
}
