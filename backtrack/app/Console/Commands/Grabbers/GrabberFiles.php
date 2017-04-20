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

class GrabberFiles extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber Files';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $client = $this->getClient();
        $items = DB::table("grab_songs_pages")->whereNull("src")->get();
        foreach ($items as $item) {
            $res = $client->get($item->href);
            $crawler = new Crawler($res->getBody()->getContents());
            $crawler = $crawler->filterXPath("//audio[contains(@data-name, 'main-audio')]");

            $src = $crawler->attr("src");
            if($src) {
                DB::table("grab_songs_pages")->where("id", $item->id)->update(['src'=>$src]);
            }

            $client->get($src, ['save_to' => '/var/www/backtrack/www/public/test.mp3']);

            exit();
        }
    }
}
