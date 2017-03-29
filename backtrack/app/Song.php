<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 28.03.2017
 * Time: 16:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Song extends Model
{
    protected $fillable = [
        'status', 'user_id', 'author_id', 'name'
    ];

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track');
    }


    public static function getOrCreate($name, $author)
    {
        $song = null;
        $author = Author::getOrCreate($author);
        if (!$song = self::where("author_id", $author->id)->where("name", $name)->first()) {
            $song = self::create([
                "name" => $name,
                "status" => 1,
                "author_id" => $author->id
            ]);
        }
        return $song;
    }
}