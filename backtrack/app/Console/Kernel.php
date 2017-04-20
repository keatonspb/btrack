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
        \App\Console\Commands\SitemapMake::class,
        \App\Console\Commands\Grabbers\GrabberArtists::class,
        \App\Console\Commands\Grabbers\GrabberSongs::class,
        \App\Console\Commands\Grabbers\GrabberFiles::class,
        \App\Console\Commands\UpdateFileHash::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('sitemap:make')
                  ->everyMinute();
        $schedule->command('grabber:files')
            ->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
