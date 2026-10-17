<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Covering index for the list-route cost aggregate
     * (SELECT project_id, SUM(quantity * amount) ... GROUP BY project_id).
     * Lets MySQL answer it as an index-only range scan.
     */
    public function up(): void
    {
        Schema::table('project_costs', function (Blueprint $table) {
            $table->index(['project_id', 'quantity', 'amount'], 'project_costs_project_id_quantity_amount_index');
        });
    }

    public function down(): void
    {
        Schema::table('project_costs', function (Blueprint $table) {
            $table->dropIndex('project_costs_project_id_quantity_amount_index');
        });
    }
};
