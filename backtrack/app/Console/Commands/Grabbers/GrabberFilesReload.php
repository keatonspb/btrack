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

class GrabberFilesReload extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:reload';

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
        exit();
        $tmp_folder = "/var/www/backtrack/www/public/";
        $client = $this->getClient();
        $items = DB::table("grab_songs_pages")->where("active", 1)->whereNotNull("track_id")->inRandomOrder()->limit(100)->get();
        
        foreach ($items as $item) {
            echo "Working with url ".$item->href."\n";
            echo $item->track_id."\n";
            echo $item->src."\n";
            $tmp_file = $tmp_folder."/".md5($item->src).".mp3";
            $client->get($item->src, ['save_to' => $tmp_file]);
            if(file_exists($tmp_file)) {
                try {
                    $track = Track::find($item->track_id);
                    $File = new UploadedFile($tmp_file, basename($tmp_file));
                    $filename = $track->upload($File);
                    unlink($tmp_file);
                    DB::table("backtrack.grab_songs_pages")->where("id", $item->id)->update(['active' => 0]);
                } catch (\Exception $e) {
                    echo $e->getMessage()."\n";
                }

            } else {
                echo "Error download:";
            }

        }
    }
}
