<?php

namespace App\Console;

use App\Console\Commands\ConvertAllStringsToJsonCommand;
use App\Console\Commands\FillProductDetailCommand;
use App\Console\Commands\ImportUsersAndOrders;
use App\Console\Commands\TransformImagesCommand;
use App\Console\Commands\UpdateTimezoneCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ConvertAllStringsToJsonCommand::class,
        UpdateTimezoneCommand::class,
        TransformImagesCommand::class,
        ImportUsersAndOrders::class,
        FillProductDetailCommand::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
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
