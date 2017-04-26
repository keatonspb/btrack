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
//        sleep(random_int(3, 15));
        $client = $this->getClient();
        $items = DB::table("grab_artists_pages")->where("active", 1)->inRandomOrder()->limit(100)->get();
        foreach ($items as $item) {
            $artist = Author::find($item->id);
            echo $artist->name."\n";
            echo "-----------\n";
            echo $item->href."\n";
            echo "-----------\n";
            $res = $client->get($item->href, ['proxy' => '152.160.35.171:80']);
            $crawler = new Crawler($res->getBody()->getContents());
            $count =0;
            $crawler->filterXPath("//table//div[contains(@class, 'gbt-b-section--table-cell__top')]/a")->each(function (Crawler $node, $i) use (&$count, $artist) {
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
                $count ++;
                echo $name . " " . $href . "\n";
            });
            if($count) {
                DB::table("grab_artists_pages")->where("id", $item->id)->update(['active' => 0]);
            }
            echo "-----------\n";
            echo "EXPORTER: ".$count."\n";
            echo "-----------\n";

        }
    }
}
