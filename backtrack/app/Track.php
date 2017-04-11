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
        'status', 'user_id', 'song_id', 'bass', 'drums', 'vocals', 'lead', 'rhythm', 'keys', 'name'
    ];
    public function upload(UploadedFile $File) {
        $filename = $this->id.".".$File->getClientOriginalExtension();
        if(!Storage::disk("s3")->put(
            self::$folder.'/'.$filename,
            file_get_contents($File->getRealPath()), 'public')) {
            throw new \LogicException("Cant upload");
        }
        return $filename;
    }
    public function getFilePath() {
        return Storage::disk("s3")->url(self::$folder."/".$this->filename);
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
            throw new \LogicException("Cant delete dile");
        }
        return parent::delete();
    }
}