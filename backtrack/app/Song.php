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

    public function tabs()
    {
        return $this->hasMany('App\Tab');
    }


    public static function getOrCreate($name, $author)
    {
        $song = null;
        if(is_numeric($author)) {
            $author = Author::find($author);
        } else {
            $author = Author::getOrCreate($author);
        }

        if (!$song = self::where("author_id", $author->id)->where("name", $name)->first()) {
            $song = self::create([
                "name" => $name,
                "status" => 1,
                "author_id" => $author->id
            ]);
            $song->createAlias();
        }
        return $song;
    }

    public function getHref() {
        return "/song/".$this->author->alias."/".$this->alias;
    }

    public function createAlias() {
        if($this->alias) return true;
        $working = true;
        $suf = "";
        $name = mb_strtolower($this->name);
        while ($working) {
            $alias = Helper::translitirate($name.$suf);
            if(Song::where("alias", $alias)->count()) {
                $suf .= "_";
                continue;
            }
            $this->alias = $alias;
            $this->save();
            $working = false;
        }
        return $this->alias;
    }
}