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
        \App\Console\Commands\Grabbers\GrabberFilesReload::class,
        \App\Console\Commands\UpdateFileHash::class,
        \App\Console\Commands\Grabbers\GrabberTabs::class,
        \App\Console\Commands\MakeAlias::class,
        \App\Console\Commands\Grabbers\GrabberLocal::class,
        \App\Console\Commands\Test::class,
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
                  ->hourly();
//        $schedule->command('grabber:songs')
//            ->everyMinute();
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
