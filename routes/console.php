<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('campaigns:update-expired', function () {
    $this->call('campaigns:update-expired');
})->purpose('Update campaigns that have ended to completed status');
