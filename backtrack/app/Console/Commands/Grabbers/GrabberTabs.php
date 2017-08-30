<?php

namespace App\Console\Commands\Grabbers;

use App\Author;
use App\Song;
use App\Tab;
use App\Tuning;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;


//INSERT INTO grab_tabs (song_id) SELECT songs.id FROM songs LEFT JOIN tabs ON tabs.song_id = songs.id WHERE tabs.id is NULL AND songs.id NOT IN (SELECT song_id FROM grab_tabs);

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
        $songs = Song::join("grab_tabs", "songs.id", "=", "grab_tabs.song_id")->leftJoin("tabs", "songs.id", "=", "tabs.song_id")->leftJoin("authors", "authors.id", "=", "songs.author_id");
        $songs->select("songs.id", "songs.name", "authors.name as author_name", "grab_tabs.id as gt_id");
        $songs->whereNull("tabs.id")->where("grab_tabs.status", "=", 1);
        $songs->limit(10);

        foreach ($songs->get() as $song) {
            $gt_id = $song->gt_id;
            $searchq =  $song->name." - ".$song->author_name;
            $url = "/search.php?view_state=advanced&band_name={$song->author_name}&song_name={$song->name}&type[]=200&type2[]=40000&rating[]=5&rating[]=4";
            echo $url."\n";

            try {
                $res = $client->get($url);
                $crawler = new Crawler($res->getBody()->getContents());
                $links = [];
                $crawler->filterXPath("//table[contains(@class, 'tresults')]//tr")
                    ->each(function (Crawler $node, $i) use (&$links) {
                        $text = $node->html();
                        if(str_contains($text,"<strong>tab</strong>")) {
                            $res = $node->filterXPath("//a[contains(@class, 'result-link')]")->first();
                            $links[] = $res->attr("href");
                        }
                    });
                foreach ($links as $link) {
                    echo $link."\n";
                    $tuning = null;
                    $res = $client->get($link);
                    $crawler = new Crawler($res->getBody()->getContents());


                    $res = $crawler->filterXPath(".//*[@id='scroll_holder']/form/div[3]/div[2]/div[3]/div");
                    if($res->count()) {
                        $tuning_res = trim($res->text());
                    } else {
                        $tuning_res = "E A D G B e";
                    }

                    if($tuning_res) {
                        echo $tuning_res."\n";
                        $Tunning = Tuning::where("strings", "=", $tuning_res)->where("instrument", "=", "guitar")->firstOrFail();
                        echo "Tunning found: ". $Tunning->name."\n";
                        $tab = $crawler->filterXPath(".//*[@id='cont']/pre[2]");
                        $tab = $tab->text();
                        $tab = preg_replace("/^x/", "", $tab);
                        echo substr($tab, 0, 500);
                        if(!Tab::where("content", $tab)->count()) {
                            $NewTab = Tab::create([
                                'song_id'=> $song->id,
                                'instrument'=>'guitar',
                                'tuning_id' => $Tunning->id,
                                'content' => $tab
                            ]);
                            echo "-------\nTab added: ".$NewTab->id." for song {$song}\n-----------\n\n\n";
                        }
                    }


                }
                DB::table("grab_tabs")->where("id", "=", $gt_id)->update(['status'=>0]);
            } catch (\Exception $e) {
                DB::table("grab_tabs")->where("id", "=", $gt_id)->update(['status'=>-1]);
                echo $e->getMessage();
            }


        }

    }
}
