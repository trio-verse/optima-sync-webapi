<?php

use App\Models\ProjectVersion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private string $tableName = 'project_costs';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasForeignKey($this->tableName, ['project_version_id']))
                $table->dropConstrainedForeignIdFor(ProjectVersion::class);

            if (Schema::hasIndex($this->tableName, [$this->tableName . '_project_version_id_index']))
                $table->dropIndex([$this->tableName . '_project_version_id_index']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (!Schema::hasForeignKey($this->tableName, 'project_version_id')) {
                if (Schema::hasColumn($this->tableName, 'project_version_id')) {
                    $table->dropColumn(['project_version_id']);
                }
                $table->foreignId('project_version_id')->nullable()->constrained('project_versions')->nullOnDelete();
            }
        });
    }
};
