<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunServerWithScheduler extends Command
{
    protected $signature = 'serve:with-scheduler';
    protected $description = 'Start development server with scheduler';

    public function handle()
    {
        $this->info("Starting Laravel development server with scheduler...");

        // Start scheduler in background (works for Windows/Linux/Mac)
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            pclose(popen('start /B php artisan schedule:work', 'r'));
        } else {
            // Linux/Mac
            exec('php artisan schedule:work > /dev/null 2>&1 &');
        }

        // Start development server
        $this->call('serve');
    }
}
