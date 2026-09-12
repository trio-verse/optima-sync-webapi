<?php

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
        Schema::create('project_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('based_on_version_id')->nullable()->constrained('project_versions')->nullOnDelete();
            $table->integer('version_number')->default(1);
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('change_description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('duration')->nullable(); // text
            // $table->enum('status', enProjectVersionStatus::all())->default(enProjectVersionStatus::DRAFT->value);
            // $table->enum('source', enProjectVersionSource::all())->default(enProjectVersionSource::INITIAL->value);
            $table->boolean('freeze')->default(false);
            $table->json('features_snapshot')->nullable();
            $table->json('costs_snapshot')->nullable();
            $table->json('members_snapshot')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            // Composite unique constraint
            $table->unique(['project_id', 'version_number']);

            // Indexes
            $table->index(['project_id', 'freeze']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_versions');
    }
};
