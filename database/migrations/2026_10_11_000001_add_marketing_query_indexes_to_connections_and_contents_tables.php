<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // $campaign->connections() / $org->connections() aggregated by stage
        // (CampaignAnalyticsService, MarketingDashboardService win & revenue sums).
        Schema::table('connections', function (Blueprint $table) {
            $table->index(
                ['organization_id', 'campaign_id', 'stage'],
                'connections_organization_id_campaign_id_stage_index'
            );
        });

        // $campaign->contents()->whereNotNull('cost_confirmed_by')->sum('cost')
        // and $org->contents() spend rollups (cost-confirmed content only).
        Schema::table('contents', function (Blueprint $table) {
            $table->index(
                ['organization_id', 'campaign_id', 'cost_confirmed_by'],
                'contents_organization_id_campaign_id_cost_confirmed_by_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->dropIndex('connections_organization_id_campaign_id_stage_index');
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->dropIndex('contents_organization_id_campaign_id_cost_confirmed_by_index');
        });
    }
};
