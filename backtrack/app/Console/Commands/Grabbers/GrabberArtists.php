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

class GrabberArtists extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:artists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber Artists';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $client = $this->getClient();

        $res = $client->get("/bands/Z.htm");
        $crawler = new Crawler($res->getBody()->getContents());
        DB::beginTransaction();
        try {
            $crawler->filterXPath("//div[contains(@class, 'gbt-b-section--table-cell__artist-song')]/a")
                ->each(function (Crawler $node, $i) {
                    $href = $node->attr("href");
                    $name = $node->text();
                    $name = preg_replace("/\n/", "", $name);
                    $name = trim($name);

                    $author = Author::getOrCreate($name);
                    DB::table("grab_artists_pages")->updateOrInsert(["id"=>$author->id],[
                        "id" => $author->id,
                        "name" => $name,
                        "source" => "gbt",
                        "href" => $this->base_url.$href,
                        "active" => 1,
                    ]);
                    echo $name. " " . $href ."\n";
                });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
