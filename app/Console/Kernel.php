<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('report:weekly')
            ->weeklyOn(1, '08:00') // Monday (1) at 08:00
            ->appendOutputTo(storage_path('logs/scheduler.log')) // Log output
            ->before(function () {
                logger()->info('[TESTING] Starting weekly report job');
            })
            ->after(function () {
                logger()->info('[TESTING] Weekly report job finished');
            });
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
