<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 28.03.2017
 * Time: 16:53
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = "rating";
    protected $fillable = [
        'track_id', 'rate', 'rater'
    ];

}