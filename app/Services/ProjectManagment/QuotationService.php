<?php

namespace App\Services\ProjectManagment;

use App\Contracts\IQuotationService;
use App\Models\ProjectVersion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class QuotationService implements IQuotationService
{
    public function __construct(private ProjectPricingService $pricingService) {}

    public function getPreviewData(ProjectVersion $version): array
    {
        $version->loadMissing(['project.organization', 'project.client', 'project.costs', 'features']);

        if ($version->freeze && is_array($version->quotation_data)) {
            return $version->quotation_data;
        }

        $project = $version->project;
        $features = $version->freeze
            ? collect($version->features_snapshot)->map(fn (array $feature) => [
                'name' => $feature['name'] ?? '',
                'description' => $feature['description'] ?? '',
            ])->values()->all()
            : $version->features->map(fn ($feature) => [
                'name' => $feature->name,
                'description' => $feature->description ?? '',
            ])->values()->all();

        $costs = $version->freeze
            ? collect($version->costs_snapshot)->map(fn (array $cost) => [
                'title' => $cost['name'] ?? '',
                'description' => $cost['description'] ?? '',
                'amount' => $cost['line_total'] ?? (($cost['quantity'] ?? 0) * ($cost['amount'] ?? 0)),
            ])->values()->all()
            : $project->costs->map(fn ($cost) => [
                'title' => $cost->name,
                'description' => $cost->description ?? '',
                'amount' => $cost->line_total,
            ])->values()->all();

        $totals = $this->pricingService->calculateQuotationTotals($project);

        $data = [
            // 'optimasync_logo' => asset('images/optima-sync-logo.jpg'),   
            'organization_name' => $project->organization?->name ?? config('app.name', 'OptimaSync'),
            'org_location' => $project->organization?->address ?? '',
            'quo_number' => $version->quotation_number ?? $this->quotationNumber($version),
            'issue_date' => $project->issue_date?->format('M d, Y') ?? now()->format('M d, Y'),
            'client_name' => $project->client?->name ?? 'Valued Client',
            'quotation_based_version_id' => $version->version_number,
            'valid_until' => $project->valid_until?->format('M d, Y'),
            'project_number' => $project->reference_id ?? 'Project_1',
            'project_title' => $version->title ?? 'Project',
            'project_description' => $version->description ?? '',
            'project_features' => $features,
            'costs' => $costs,
            'development_fee' => $totals['development_fee'],
            'added_costs_total' => $totals['added_costs_total'],
            'subtotal' => $totals['subtotal'],
            'tax' => $totals['tax'],
            'discount' => $totals['discount'],
            'total' => $totals['total'],
            'currency' => config('app.currency', 'USD'),
            'payment_terms' => $project->payment_terms ?? config('app.payment_terms', 'Net 30'),
        ];

        if ($version->freeze) {
            $version->forceFill([
                'quotation_number' => $data['quo_number'],
                'quotation_data' => $data,
            ])->save();
        }

        return $data;
    }

    private function quotationNumber(ProjectVersion $version): string
    {
        return sprintf('QTN-%s-%d-%d', now()->format('Ym'), $version->project_id, $version->id);
    }

}
