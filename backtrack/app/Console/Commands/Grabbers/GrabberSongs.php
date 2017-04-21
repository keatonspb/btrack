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

class GrabberSongs extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:songs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber Songs';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $client = $this->getClient();
        $items = DB::table("grab_artists_pages")->where("active", 1)->inRandomOrder()->limit(10)->get();
        foreach ($items as $item) {
            $artist = Author::find($item->id);
            echo $artist->name."\n";
            echo "-----------\n";
            $res = $client->get($item->href);
            $crawler = new Crawler($res->getBody()->getContents());
            $crawler->filterXPath("//table//div[contains(@class, 'gbt-b-section--table-cell__top')]/a")->each(function (Crawler $node, $i) use ($artist) {
                $href = $node->attr("href");
                $name = $node->text();
                $name = preg_replace("/\n/", "", $name);
                $name = trim($name);
                DB::table("grab_songs_pages")->updateOrInsert(["author_id" => $artist->id, "name" => $name], [
                    "author_id" => $artist->id,
                    "source" => "gbt",
                    "name" => $name,
                    "href" => $href,
                    "active" => 1
                ]);
                echo $name . " " . $href . "\n";
            });
            DB::table("grab_artists_pages")->where("id", $item->id)->update(['active' => 0]);

        }
    }
}
