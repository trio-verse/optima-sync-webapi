<?php

use App\Enums\Workspace\enTaskPriority;
use App\Enums\Workspace\enTaskStatus;
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
            $table->foreignId('member_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('workspace_id')->constrained('workspaces')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', enTaskPriority::all())->default(enTaskPriority::MEDIUM->value);
            $table->enum('status', enTaskStatus::all())->default(enTaskStatus::PENDING->value);

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
