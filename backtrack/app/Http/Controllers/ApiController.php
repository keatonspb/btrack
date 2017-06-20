<?php
/**
 * Created by PhpStorm.
 * User: default
 * Date: 12.04.2017
 * Time: 22:54
 */

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function search(Request $request) {
        $q = $request->get("q");
        $songs = Song::orderBy("created_at", "DESC");
        $appends = [];
        if($q) {
            $songs->where("songs.name", "like", $q."%")->orWhere('authors.name', "like", $q."%");
            $appends['q'] = $q;
        }
        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->groupBy("songs.id");
        $songs->select("songs.*", "authors.name as author_name");
        $songs->with("tracks");

        $json = $songs->paginate(10)->appends($appends)->toArray();
        return json_encode($json); 

    }
}