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
        Schema::table('connections', function (Blueprint $table) {
            $table->index(
                ['organization_id', 'created_at'],
                'idx_connections_org_created'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('connections', function (Blueprint $table) {
            $table->dropIndex('idx_connections_org_created');
        });
    }
};
