<?php

namespace App\Services\ProjectManagment;

use App\Models\Project;
use App\Models\ProjectVersion;
use App\Models\Quotation;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class QuotationService
{
    public function getVersionQuotations(ProjectVersion $version)
    {
        return $version->quotation()
            ? [$version->quotation]
            : [];
    }

    public function createQuotation(ProjectVersion $version, array $data)
    {
        return DB::transaction(function () use ($version, $data) {
            if (empty($data['quotation_number'])) {
                $data['quotation_number'] = Quotation::generateQuotationNumber();
            }

            $data['created_by'] = auth()->id();
            $data['project_version_id'] = $version->id;

            $totals = $this->calculateQuotationTotals($version);
            $data = array_merge($data, $totals);

            $quotation = Quotation::create($data);

            return $quotation;
        });
    }

    public function getQuotation($quotationId, ProjectVersion $version)
    {
        return $version->quotation()->find($quotationId);
    }

    public function updateQuotation($quotationId, ProjectVersion $version, array $data)
    {
        $quotation = $this->getQuotation($quotationId, $version);

        if (!$quotation) {
            return null;
        }

        if ($this->shouldRecalculateTotals($data, $quotation)) {
            $totals = $this->calculateQuotationTotals($version);
            $data = array_merge($data, $totals);
        }

        $quotation->update($data);

        return $quotation->fresh();
    }

    public function changeStatus($quotationId, ProjectVersion $version, string $status)
    {
        $quotation = $this->getQuotation($quotationId, $version);

        if (!$quotation) {
            return null;
        }

        $quotation->update(['status' => $status]);

        if ($status === 'sent' && !$version->freeze) {
            $version->freezeVersion();
        }

        return $quotation->fresh();
    }

    /**
     * Build the data array for the quotation-invoice blade view.
     * Matches the contract:
     *   optimasync_logo, organization_name, org_location,
     *   quo_number, issue_date, client_name, quotation_based_version_id,
     *   valid_until, project_title, project_description,
     *   project_features [{name, description}],
     *   costs [{title, description, amount}],
     *   development_fee, added_costs_total, tax, discount, subtotal, total,
     *   payment_terms, currency
     */
    public function previewData(Quotation $quotation): array
    {
        $version = $quotation->projectVersion;
        $project = $version->project;

        if ($quotation->data != [] && $version->freeze)
            return $quotation->data;

        $organization = $project->organization;
        $client = $project->client;


        if ($version->freeze) {
            // dd($version->features_snapshot);
            $features = collect($version->features_snapshot)->map(fn($feature) => [
                'name' => $feature['name'],
                'description' => $feature['description'] ?? '',
            ])->toArray();

            $costs = collect($version->costs_snapshot)->map(fn($cost) => [
                'title' => $cost['name'],
                'description' => $cost['description'] ?? '',
                'amount' => $cost['line_total'],
            ])->toArray();

        } else {
            // Features with name + description
            $features = $project->features->map(fn($feature) => [
                'name' => $feature->name,
                'description' => $feature->description ?? '',
            ])->toArray();

            // Costs with title + description + amount (line_total = quantity * amount)
            $costs = $project->costs->map(fn($cost) => [
                'title' => $cost->name,
                'description' => $cost->description ?? '',
                'amount' => $cost->line_total,
            ])->toArray();
        }


        $addedCostsTotal = (float) collect($costs)->sum('amount');
        $developmentFee = $this->calculateDevelopmentFee($project);
        $total_budget = $developmentFee + $addedCostsTotal;

        $tax_number = $quotation->tax ?? 0;
        $discount_number = $quotation->discount ?? 0;
        $final_price = $total_budget + $tax_number - $discount_number;

        $data = [
            'optimasync_logo' => asset('images/optima-sync-logo.jpg'),
            'organization_name' => $organization?->name ?? config('app.name', 'OptimaSync'),
            'org_location' => $organization?->address ?? '',
            'quo_number' => $quotation->quotation_number,
            'issue_date' => $quotation->issue_date?->format('M d, Y') ?? now()->format('M d, Y'),
            'client_name' => $client?->name ?? 'Valued Client',
            'quotation_based_version_id' => $version->version_number,
            'valid_until' => $quotation->valid_until?->format('M d, Y') ?? null,
            'project_number' => $project->reference_id ?? 'Project_1',
            'project_title' => $version->title ?? 'Project_test',
            'project_description' => $version->description ?? 'test description',
            'project_features' => $features,
            'costs' => $costs,
            'development_fee' => $developmentFee,
            'added_costs_total' => $addedCostsTotal,
            'subtotal' => $total_budget,
            'tax' => $tax_number ,
            'discount' => $discount_number ,
            'total' => $final_price,
            'currency' => config('app.currency', 'USD'),
            'payment_terms' => $quotation->payment_terms ?? config('app.payment_terms', 'Net 30'),
        ];

        $quotation->update(['data' => $data]);

        return $data;
    }

    public function generatePdf(Quotation $quotation): array
    {
        try {
            $data = $this->previewData($quotation);

            $html = view('index', [
                'data' => $data
            ])->render();

            $pdfPath = $this->buildPdfPath($quotation);

            $pdfBytes = Browsershot::html($html)
                ->format('A4')
                ->showBackground()
                ->timeout(120)
                ->setCustomTempPath(asset('/temp'))
                ->pdf();

            Storage::disk('public')->put($pdfPath, $pdfBytes);

            $quotation->update([
                'pdf_path' => $pdfPath
            ]);

            return [
                'success' => true,
                'message' => 'PDF generated successfully',
                'pdf_path' => $pdfPath,
                'pdf_url' => url('storage/' . $pdfPath),
                'quotation' => $quotation->fresh(),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage(),
            ];
        }
    }

    public function downloadPdf(Quotation $quotation)
    {
        if (!$quotation->pdf_path || !Storage::disk('public')->exists($quotation->pdf_path)) {
            abort(404, 'PDF not found. Please generate the PDF first.');
        }

        $pdfBytes = Storage::disk('public')->get($quotation->pdf_path);

        return response($pdfBytes, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $quotation->quotation_number . '.pdf"',
        ]);
    }

    protected function calculateQuotationTotals(ProjectVersion $version): array
    {
        $project = $version->project;
        $subtotal = (float) ($project->total_amount ?? $project->calculateTotalCosts());

        return [
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ];
    }

    protected function calculateDevelopmentFee(Project $project): float
    {
        return $project->total_amount == 0 ? ($project->sub_total * ($project->profit_percentage / 100) + $project->sub_total ) : $project->total_amount;
    }

    protected function shouldRecalculateTotals(array $data, Quotation $quotation): bool
    {
        return isset($data['discount']) || isset($data['tax']);
    }

    protected function buildPdfPath(Quotation $quotation): string
    {
        $project = $quotation->projectVersion->project;
        $organizationId = $project->organization_id;
        $quotationNumber = str_replace(['/', '\\'], '-', $quotation->quotation_number);

        return "quotations/{$organizationId}/{$project->id}/{$quotationNumber}.pdf";
    }
}
