<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $subtotal = (float) ($this['subtotal'] ?? 0);
        $discount = (float) ($this['discount'] ?? 0);
        $tax = (float) ($this['tax'] ?? 0);
        $total = (float) ($this['total'] ?? 0);
        $validUntil = $this['valid_until'] ?? null;

        return [
            'id' => $this['id'],
            'project_version_id' => $this['project_version_id'],
            'quotation_number' => $this['quotation_number'],
            'issue_date' => $this['issue_date'] ?? null,
            'valid_until' => $validUntil,
            'is_expired' => $validUntil
                ? Carbon::parse($validUntil)->lt(now()->startOfDay())
                : false,
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
            'formatted_subtotal' => number_format($subtotal, 2),
            'formatted_discount' => number_format($discount, 2),
            'formatted_tax' => number_format($tax, 2),
            'formatted_total' => number_format($total, 2),
            'pdf_path' => $this['pdf_path'] ?? null,
            'pdf_url' => isset($this['pdf_path']) && $this['pdf_path']
                ? url('storage/' . $this['pdf_path'])
                : null,
            'created_by' => $this['created_by'] ?? null,
            'created_by_user' => $this['created_by_user'] ?? null,
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
