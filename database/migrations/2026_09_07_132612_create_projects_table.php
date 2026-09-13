<?php

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Models\ProjectVersion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->enum('status', enProjectStatus::all())->default(enProjectStatus::NEW ->value);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->enum('source', enProjectSource::all())->default(enProjectSource::INTERNAL->value);
            $table->decimal('sub_total' , 10 , 2);
            $table->integer('profit_percentage');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            // Indexes
            $table->index(['organization_id', 'status']);
            $table->index('reference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
