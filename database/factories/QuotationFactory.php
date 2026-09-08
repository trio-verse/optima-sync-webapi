<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quotation>
 */
class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 5000, 30000);
        $discount = fake()->randomFloat(2, 0, 1000);
        $tax = round(($subtotal - $discount) * 0.15, 2);

        return [
            'project_version_id' => 1,
            'quotation_number' => 'QTN-' . fake()->unique()->numerify('202609-####'),
            'issue_date' => now()->toDateString(),
            'valid_until' => now()->addDays(30)->toDateString(),
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'total' => number_format($subtotal - $discount + $tax, 2, '.', ''),
            'pdf_path' => null,
            'created_by' => 1,
        ];
    }

    /**
     * Build a fake-persistence DTO array (no database).
     */
    public static function dto(int $id, int $versionId, array $overrides = []): array
    {
        $base = (new static)->definition();

        return array_merge($base, [
            'id' => $id,
            'project_version_id' => $versionId,
            'quotation_number' => $overrides['quotation_number'] ?? sprintf('QTN-202609-%04d', $id),
            'issue_date' => $overrides['issue_date'] ?? '2026-09-01',
            'valid_until' => $overrides['valid_until'] ?? '2026-10-01',
            'subtotal' => $overrides['subtotal'] ?? '10000.00',
            'discount' => $overrides['discount'] ?? '500.00',
            'tax' => $overrides['tax'] ?? '950.00',
            'total' => $overrides['total'] ?? '10450.00',
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
            'created_at' => '2026-09-01T10:00:00.000000Z',
            'updated_at' => '2026-09-01T10:00:00.000000Z',
        ], $overrides);
    }
}
