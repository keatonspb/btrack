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
        return Storage::disk("s3")->url(self::$folder."/".$this->id);
    }
    public function author()
    {
        return $this->belongsTo('App\Author');
    }
    public function song()
    {
        return $this->belongsTo('App\Song');
    }
}