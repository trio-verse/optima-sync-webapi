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
        Schema::table('project_versions', function (Blueprint $table) {
            if (Schema::hasColumn('project_versions', 'members_snapshot') && !Schema::hasColumn('project_versions', 'employees_snapshot')) {
                $table->renameColumn('members_snapshot', 'employees_snapshot');
            } elseif (!Schema::hasColumn('project_versions', 'employees_snapshot')) {
                $table->json('employees_snapshot')->nullable()->after('costs_snapshot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_versions', function (Blueprint $table) {
            if (Schema::hasColumn('project_versions', 'employees_snapshot')) {
                $table->renameColumn('employees_snapshot', 'members_snapshot');
            }
        });
    }
};
