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
            $url = "/search.php?view_state=advanced&band_name={$song->author_name}&song_name={$song->name}&type[]=200&type2[]=40000&rating[]=5&rating[]=4";
            echo $url."\n";
            $res = $client->get($url);
            $crawler = new Crawler($res->getBody()->getContents());
            $links = [];
            try {
                $crawler->filterXPath("//table[contains(@class, 'tresults')]//tr")
                    ->each(function (Crawler $node, $i) use (&$links) {
                        $text = $node->html();
                        if(str_contains($text,"<strong>tab</strong>")) {
                            $res = $node->filterXPath("//a[contains(@class, 'result-link')]")->first();
                            $links[] = $res->attr("href");
                        }
                    });
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo "<pre>";
            print_r($links);
            echo "</pre>";
        }

    }
}
