<?php

namespace App\Console\Commands;

use App\Author;
use App\Song;
use App\Track;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MakeAlias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:makealias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Making File Alias';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $items = Author::whereNull("alias")->get();
        foreach ($items as $item) {
            echo $item->name."\n";
            echo $item->createAlias()."\n";
        }
        $items = Song::whereNull("alias")->get();
        foreach ($items as $item) {
            echo $item->name."\n";
            echo $item->createAlias()."\n";
        }
    }
}
