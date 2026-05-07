<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:init')]
#[Description('Command description')]
class Init extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Init command
    }
}
