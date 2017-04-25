<?php

namespace App\Console\Commands\Grabbers;

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
        $tmp_folder = "/var/www/backtrack/www/public/";
        $client = $this->getClient();
        $items = DB::table("grab_songs_pages")->where("active", 1)->inRandomOrder()->limit(1)->get();
        foreach ($items as $item) {
            echo "Working with url ".$item->href."\n";
            $res = $client->get($item->href, ['proxy' => $this->getProxy()]);
            $crawler = new Crawler($res->getBody()->getContents());
            $crawlerA = $crawler->filterXPath("//audio[contains(@data-name, 'main-audio')]");

            $src = $crawlerA->attr("src");
            if($src) {
                DB::table("grab_songs_pages")->where("id", $item->id)->update(['src'=>$src]);
            }
            $tmp_file = $tmp_folder."/".md5($src).".mp3";

            $client->get($src, ['save_to' => $tmp_file]);
            if(file_exists($tmp_file)) {
                $md5 = md5_file($tmp_file);
                if($existsTrack = DB::table("tracks")->where("hash", $md5)->first()) {
                    echo "Track exists\n";
                    DB::table("backtrack.grab_songs_pages")->where("id", $item->id)->update(['active' => 0, 'track_id'=>$existsTrack->id]);
                    unlink($tmp_file);
                    continue;
                }
                $song_name = preg_replace("/\(\d\)/", "", $item->name);
                $song_name = trim($song_name);
                echo $song_name."\n";
                $row = [
                    "bass" => true,
                    "drums" => true,
                    "vocals" => true,
                    "lead" => true,
                    "rhythm" => true,
                    "keys" => true,
                ];
                $partsCrawler = $crawler->filterXPath("//div[contains(@class, 'b-player--info-block')]/span")
                    ->each(function (Crawler $node, $i) use (&$row) {
                        if($node->attr("class") == 'text-gray') {
                            $row[strtolower($node->text())] = false;
                        }
                    });
                DB::beginTransaction();
                try {
                    DB::commit();
                    $song = Song::getOrCreate($song_name, $item->author_id);
                    $row['status'] = 1;
                    $row['song_id'] = $song->id;
                    $row['user_id'] = 1;
                    echo "<pre>";
                    print_r($row);
                    echo "</pre>";
                    $track = Track::create($row);
                    $File = new UploadedFile($tmp_file, basename($tmp_file));
                    $filename = $track->upload($File);
                    DB::table("backtrack.grab_songs_pages")->where("id", $item->id)->update(['active' => 0, 'track_id'=>$track->id]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    echo "ERROR: ".$e->getMessage()."\n";
                }
                unlink($tmp_file);
            }
        }
    }
}
