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
         $schedule->command('onus:daily_revenue')->dailyAt('02:00');
         $schedule->command('bill:remind')->dailyAt('7:00');
         $schedule->command('bill:remind')->dailyAt('19:00');

         for ($i = 3; $i <= 10; $i++) {
             $schedule->command('credit:remind')->monthlyOn($i, '9:00');
         }
         for ($i = 19; $i <= 26; $i++) {
             $schedule->command('credit:remind')->monthlyOn($i, '9:00');
         }
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
