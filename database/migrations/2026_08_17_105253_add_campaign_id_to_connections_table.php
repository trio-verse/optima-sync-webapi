<?php

use App\Models\Campaign;
use App\Models\Campain;
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
            $table->foreignId('campaign_id')->nullable()->after('organization_id')->constrained('campaigns')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->dropForeignIdFor(Campaign::class , 'campain_id');
        });
    }
};
