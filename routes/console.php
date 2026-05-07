<?php

use Illuminate\Support\Facades\Schedule;

// // Custom Commands
// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command('queue:prune-failed --hours=72')->daily();

// Backup
if(config("app.env") == "production"){
    Schedule::command('backup:run')->dailyAt('20:00');
    Schedule::command('backup:clean')->dailyAt('21:00');
}