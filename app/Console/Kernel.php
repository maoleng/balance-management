<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('crypto:notify')->everyFiveMinutes();
         $schedule->command('onus:daily_revenue')->dailyAt('02:00');
         $schedule->command('bill:remind')->dailyAt('7:00');
         $schedule->command('bill:remind')->dailyAt('19:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
