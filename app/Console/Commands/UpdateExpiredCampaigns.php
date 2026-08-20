<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateExpiredCampaigns extends Command
{
    protected $signature = 'campaigns:update-expired';
    protected $description = 'Update campaigns that have ended to completed status';

    public function handle()
    {
        $now = Carbon::now();
        
        $campaigns = Campaign::where('status', '!=', 'completed')
            ->where('end_date', '<', $now->toDateString())
            ->get();

        $updatedCount = 0;

        foreach ($campaigns as $campaign) {
            $campaign->update(['status' => 'completed']);
            $updatedCount++;
            
            $this->info("Updated campaign ID {$campaign->id} ({$campaign->name}) to completed status");
        }

        $this->info("Updated {$updatedCount} campaigns to completed status");
        
        return 0;
    }
}
