<?php

namespace App\Console;

use App\Jobs\GetCurrentWeatherData;
use App\Jobs\GetForecastWeatherData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Check for updates for Current Weather data for every five minutes as a background process.
        $schedule->job(new GetCurrentWeatherData)
                 ->everyFiveMinutes()
                 ->withoutOverlapping(1)
                 ->runInBackground();

        //Check for updates for Forecast Weather data for every five minutes as a background process.
        $schedule->job(new GetForecastWeatherData)
                 ->hourly()
                 ->withoutOverlapping(1)
                 ->runInBackground();
    }

    /**
     * Register the commands for the application.
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
