<?php

use App\Enums\enWorkspaceTaskPriorities;
use App\Enums\enWorkspaceTaskStatus;
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
        Schema::create('tasks', function (Blueprint $table) {

            $table->id();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('workspace_id')->constrained('workspaces')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('priority', enWorkspaceTaskPriorities::all())->default(enWorkspaceTaskPriorities::MEDIUM->value);
            $table->enum('status', enWorkspaceTaskStatus::all())->default(enWorkspaceTaskStatus::PENDING->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
