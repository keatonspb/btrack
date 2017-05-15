<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 28.03.2017
 * Time: 16:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Track extends Model
{
    const CUES = [
        "intro" => "Intro",
        "bridge" => "Bridge",
        "verse" => "Verse",
        "pre-chorus" => "Pre-Chorus",
        "chorus" => "Chorus",
        "bridge" => "Bridge",
        "pre-solo" => "Pre-Solo",
        "solo" => "Solo",
        "outro" => "Outro",
    ];
    protected static $folder = "tracks";
    protected $fillable = [
        'status', 'user_id', 'song_id', 'bass', 'drums', 'vocals', 'lead', 'rhythm', 'keys', 'name', 'filename', 'url'
    ];
    public function upload(UploadedFile $File) {
        $filename = $this->id.".".$File->getClientOriginalExtension();
        $hash = md5_file($File->getRealPath());
        if(!Storage::disk("s3")->put(
            self::$folder.'/'.$filename,
            file_get_contents($File->getRealPath()), 'public')) {
            throw new \LogicException("Cant upload");
        }
        $this->filename = $filename;
        $this->url = $this->getFilePath();
        $this->hash = $hash;
        $this->save();
        return $filename;
    }



    public function getFilePath() {
        if($this->url) return $this->url;
        $this->url = Storage::disk("s3")->url(self::$folder."/".$this->filename);
        $this->save();
        return $this->url;

    }
    public function getFileHash() {
        $adapter = Storage::disk("s3")->getDriver()->getAdapter();
        if ($adapter instanceof AwsS3Adapter) {
            $object = $adapter->getClient()->getObject([
                'Bucket' => $adapter->getBucket(),
                'Key' => self::$folder."/".$this->filename
            ]);
            return str_replace('"', "", $object->get("ETag"));
        }
        return null;
    }


    public function getAlternativeTracks() {
        return Track::where("song_id", $this->song_id)->where("id", "!=", $this->id)->get();
    }
    public function author()
    {
        return $this->belongsTo('App\Author');
    }
    public function song()
    {
        return $this->belongsTo('App\Song');
    }


    public function getCues() {
        if(!$this->properties) return [];
        $props = json_decode($this->properties);
        return $props->cues ?? [];
    }

    public function delete()
    {
        if(!Storage::disk("s3")->delete(self::$folder."/".$this->filename)) {
//            throw new \LogicException("Cant delete file");
        }
        return parent::delete();
    }
}