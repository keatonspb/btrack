<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 28.03.2017
 * Time: 16:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name'
    ];
    public static function getOrCreate($name)
    {
        if(!$author = self::where("name", $name)->first()) {
            $author = self::create(['name'=>$name]);
        }
        return $author;
    }
}