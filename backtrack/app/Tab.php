<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 28.03.2017
 * Time: 16:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $fillable = [
        'song_id', 'instrument', 'tuning_id', 'content'
    ];
}