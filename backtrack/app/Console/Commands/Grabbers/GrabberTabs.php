<?php

namespace App\Console\Commands\Grabbers;

use App\Author;
use App\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class GrabberTabs extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:tabs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber Songs';
    protected $base_url = "https://ultimate-guitar.com";


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $client = $this->getClient();
        $songs = Song::leftJoin("tabs", "songs.id", "=", "tabs.song_id")->leftJoin("authors", "authors.id", "=", "songs.author_id");
        $songs->select("songs.id", "songs.name", "authors.name as author_name");
        $songs->whereNull("tabs.id");
        $songs->limit(1);

        foreach ($songs->get() as $song) {
            $searchq =  $song->name." - ".$song->author_name;
            echo $searchq ."\n";
            $url = "search.php?search_type=title&order=&value=".$searchq;
            echo $url."\n";
            $res = $client->get($url);
            echo $res->getBody()->getContents();
            $crawler = new Crawler($res->getBody()->getContents());
        }

    }
}
