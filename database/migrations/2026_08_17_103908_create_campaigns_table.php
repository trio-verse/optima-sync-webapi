<?php

use App\Enums\enCampaignStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->enum('status', enCampaignStatus::all())->default(enCampaignStatus::DRAFT->value);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->float('expected_budget')->nullable();
            $table->smallInteger('estimated_content_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
