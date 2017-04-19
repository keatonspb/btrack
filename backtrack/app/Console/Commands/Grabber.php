<?php

namespace App\Console\Commands;

use App\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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
        $client = new Client();
        $res = $client->get($base_url);
        $str = $res->getBody();
        echo $str;
    }
}
