<?php

namespace App\Services\ProjectManagment;

use App\Models\ProjectVersion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class QuotationService
{
    public function __construct(private ProjectPricingService $pricingService)
    {
    }

    public function previewData(ProjectVersion $version): array
    {
        $version->loadMissing(['project.organization', 'project.client', 'project.costs', 'features']);

        if ($version->freeze && is_array($version->quotation_data)) {
            return $version->quotation_data;
        }

        $project = $version->project;
        $features = $version->freeze
            ? collect($version->features_snapshot)->map(fn(array $feature) => [
                'name' => $feature['name'] ?? '',
                'description' => $feature['description'] ?? '',
            ])->values()->all()
            : $version->features->map(fn($feature) => [
                'name' => $feature->name,
                'description' => $feature->description ?? '',
            ])->values()->all();

        $costs = $version->freeze
            ? collect($version->costs_snapshot)->map(fn(array $cost) => [
                'title' => $cost['name'] ?? '',
                'description' => $cost['description'] ?? '',
                'amount' => $cost['line_total'] ?? (($cost['quantity'] ?? 0) * ($cost['amount'] ?? 0)),
            ])->values()->all()
            : $project->costs->map(fn($cost) => [
                'title' => $cost->name,
                'description' => $cost->description ?? '',
                'amount' => $cost->line_total,
            ])->values()->all();

        $totals = $this->pricingService->calculateQuotationTotals($project);

        $data = [
            'optimasync_logo' => asset('images/optima-sync-logo.jpg'),
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

    public function generatePdf(ProjectVersion $version): array
    {
        // dd(Storage::disk('public')->exists($version->quotation_pdf_path ?: "xfsdecx"));
        if ($version->quotation_pdf_path && $version->quotation_pdf_path != "") {
            if (Storage::disk('public')->exists($version->quotation_pdf_path))
                return [
                    'success' => true,
                    'message' => 'PDF retreived successfully',
                    // 'pdf_path' => $version->quotation_pdf_path,
                    'pdf_url' => asset("storage/" . $version->quotation_pdf_path),
                ];
        }

        try {
            $data = $this->previewData($version);

            $logoPath = public_path('images/optima-sync-logo.jpg');

            if (!file_exists($logoPath)) {
                throw new \Exception("Logo not found: {$logoPath}");
            }

            $data['optimasync_logo'] = 'data:image/jpeg;base64,' .
                base64_encode(file_get_contents($logoPath));

            $html = view('quotations.quotation', [
                'data' => $data,
            ])->render();



            $pdfPath = $this->buildPdfPath($version);
            $browserShot = Browsershot::html($html)
                ->setNodeModulePath(base_path('node_modules'))
                ->format('A4')
                ->timeout(120);

            if ($chromePath = env('BROWSERSHOT_CHROME_PATH')) {
                $browserShot->setChromePath($chromePath);
            }

            $pdfBytes = $browserShot->pdf();

            Storage::disk('public')->put($pdfPath, $pdfBytes);

            return DB::transaction(function () use ($version, $pdfPath, $data) {

                $version->forceFill([
                    'quotation_number' => $data['quo_number'],
                    'quotation_data' => $data,
                    'quotation_pdf_path' => $pdfPath,
                    'quotation_generated_at' => now(),
                ])->save();

                Log::info("version info saved => time : " . now());
                if (!$version->freeze) {
                    $version->loadMissing(['features', 'project.costs', 'project.employees']);
                    $version->freezeVersion();
                }

                Log::info("version freezed info saved => time : " . now());

                return [
                    'success' => true,
                    'message' => 'PDF generated successfully',
                    'pdf_path' => $pdfPath,
                    'pdf_url' => url('storage/' . $pdfPath),
                ];
            });

        } catch (\Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $exception->getMessage(),
            ];
        }
    }

    public function downloadPdf(ProjectVersion $version)
    {
        if (!$version->quotation_pdf_path || !Storage::disk('public')->exists($version->quotation_pdf_path)) {
            abort(404, 'PDF not found. Please generate the PDF first.');
        }

        return response(Storage::disk('public')->get($version->quotation_pdf_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $version->quotation_number . '.pdf"',
        ]);
    }

    private function quotationNumber(ProjectVersion $version): string
    {
        return sprintf('QTN-%s-%d-%d', now()->format('Ym'), $version->project_id, $version->id);
    }

    private function buildPdfPath(ProjectVersion $version): string
    {
        return sprintf(
            'quotations/%d/%d/version-%d.pdf',
            $version->project->organization_id,
            $version->project_id,
            $version->version_number,
        );
    }
}
