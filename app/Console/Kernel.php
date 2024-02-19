<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // 'App\Console\Commands\CallRoute',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('many:jobalert')->twiceDailyAt(8, 12);	
        $schedule->command('many:jobalert')->twiceDailyAt(16, 20);	
        $schedule->command('twice:jobalert')->twiceDailyAt(8, 16);	
        $schedule->command('daily:jobalert')->dailyAt('11:00');
        $schedule->command('delete:useraccount')->everyMinute();

        // $schedule->command('daily:jobalert')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }

}
