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

class Track extends Model
{
    protected static $folder = "tracks";
    protected $fillable = [
        'status', 'user_id', 'author_id', 'bass', 'drums', 'vocals', 'lead', 'rhythm', 'keys', 'name'
    ];
    public function upload($File) {
//        $File->store(
//            self::$folder.'/'.$this->id, 's3', 'public'
//        );
        if(!Storage::disk("s3")->put(
            self::$folder.'/'.$this->id,
            file_get_contents($File->getRealPath()))) {
            throw new \LogicException("Cant upload");
        }

    }
    public function getFilePath() {
        return Storage::disk("s3")->url(self::$folder."/".$this->id);
    }
    public function author()
    {
        return $this->belongsTo('App\Author');
    }
}