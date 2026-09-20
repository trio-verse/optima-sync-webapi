<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('discount', 15, 2)->default(0)->after('total_amount');
            $table->decimal('tax', 15, 2)->default(0)->after('discount');
            $table->date('issue_date')->nullable()->after('tax');
            $table->date('valid_until')->nullable()->after('issue_date');
            $table->string('payment_terms')->nullable()->after('valid_until');
        });

        Schema::table('project_versions', function (Blueprint $table) {
            $table->string('quotation_number')->nullable()->unique()->after('employees_snapshot');
            $table->string('quotation_pdf_path')->nullable()->after('quotation_number');
            $table->json('quotation_data')->nullable()->after('quotation_pdf_path');
            $table->timestamp('quotation_generated_at')->nullable()->after('quotation_data');
        });

        if (Schema::hasTable('quotations')) {
            DB::table('quotations')
                ->join('project_versions', 'project_versions.id', '=', 'quotations.project_version_id')
                ->select([
                    'quotations.*',
                    'project_versions.project_id',
                ])
                ->orderBy('quotations.id')
                ->get()
                ->each(function (object $quotation): void {
                    DB::table('projects')
                        ->where('id', $quotation->project_id)
                        ->update([
                            'discount' => $quotation->discount,
                            'tax' => $quotation->tax,
                            'issue_date' => $quotation->issue_date,
                            'valid_until' => $quotation->valid_until,
                            'payment_terms' => $quotation->payment_terms ?? null,
                        ]);

                    DB::table('project_versions')
                        ->where('id', $quotation->project_version_id)
                        ->update([
                            'quotation_number' => $quotation->quotation_number,
                            'quotation_pdf_path' => $quotation->pdf_path,
                            'quotation_data' => $quotation->data,
                            'quotation_generated_at' => $quotation->pdf_path ? $quotation->updated_at : null,
                        ]);
                });

            Schema::drop('quotations');
        }
    }

    public function down(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_version_id')->constrained('project_versions')->cascadeOnDelete();
            $table->string('quotation_number')->unique();
            $table->date('issue_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('data')->nullable();
            $table->string('payment_terms')->nullable();
            $table->timestamps();
        });

        Schema::table('project_versions', function (Blueprint $table) {
            $table->dropUnique(['quotation_number']);
            $table->dropColumn([
                'quotation_number',
                'quotation_pdf_path',
                'quotation_data',
                'quotation_generated_at',
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'discount',
                'tax',
                'issue_date',
                'valid_until',
                'payment_terms',
            ]);
        });
    }
};
