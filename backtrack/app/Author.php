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
        'name', 'alias'
    ];
    public static function getOrCreate($name)
    {
        $name = trim($name);
        if(!$author = self::where("name", $name)->first()) {
            $author = self::create(['name'=>$name]);
            $author->createAlias();
        }
        return $author;
    }



    public function createAlias() {
        if($this->alias) return true;
        $working = true;
        $suf = "";
        $name = mb_strtolower($this->name);
        while ($working) {
            $alias = Helper::translitirate($name.$suf);
            if(Author::where("alias", $alias)->count()) {
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