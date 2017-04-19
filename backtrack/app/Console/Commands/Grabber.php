<?php

namespace App\Console\Commands;

use App\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class Grabber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:grab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $base_url = "https://www.guitarbackingtrack.com/bands/A.htm";
        Guzzle
    }
}
