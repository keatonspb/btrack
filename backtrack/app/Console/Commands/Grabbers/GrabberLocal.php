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

class GrabberLocal extends BaseGrabber
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber Local Files';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $tmp_folder = "/var/www/backtrack/files/wvocal";
        foreach(glob($tmp_folder.'/*') as $file)
        {
            echo "Filename: " . $file . "\n";
            $id3 = new \Zend_Media_Id3v1($file);
            $artist =  $id3->getArtist();
            $song_name =  $id3->getTitle();
            echo "artist: ".$artist."\n";
            echo "song: ".$song_name."\n";
            $md5 = md5_file($file);
            if($existsTrack = DB::table("tracks")->where("hash", $md5)->first()) {
                echo "Track exists\n";
                unlink($file);
                continue;
            }
            $row = [
                "bass" => true,
                "drums" => false,
                "vocals" => true,
                "lead" => true,
                "rhythm" => true,
                "keys" => true,
            ];
            DB::beginTransaction();
            try {
                DB::commit();
                $song = Song::getOrCreate($song_name, $artist);
                $row['status'] = 1;
                $row['song_id'] = $song->id;
                $row['user_id'] = 1;
                echo "<pre>";
                print_r($row);
                echo "</pre>";
                $track = Track::create($row);
                $File = new UploadedFile($file, basename($file));
                $filename = $track->upload($File);
            } catch (\Exception $e) {
                DB::rollBack();
                echo "ERROR: ".$e->getMessage()."\n";
            }

        }

    }
}
