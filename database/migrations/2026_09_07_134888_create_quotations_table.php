<?php

use App\Enums\enQuotationStatus;
use App\Enums\enCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_version_id')->constrained('project_versions')->cascadeOnDelete();
            $table->string('quotation_number')->unique();
            $table->date('issue_date');
            $table->date('valid_until');
            $table->decimal('subtotal', 15, 2)->default(0); // price after profit percentage is applied
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            // Indexes
            $table->index('project_version_id');
            $table->index('quotation_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
