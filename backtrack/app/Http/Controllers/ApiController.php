<?php
/**
 * Created by PhpStorm.
 * User: default
 * Date: 12.04.2017
 * Time: 22:54
 */

namespace App\Http\Controllers;

use App\Song;
use App\Track;
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

    public function searchTracks(Request $request) {
        $q = $request->get("q");
        $tracks = Track::orderBy("tracks.rating", "DESC")->orderBy("tracks.created_at", "DESC");

        $tracks->with("tracks");
        $tracks->leftJoin('songs', "tracks.song_id", "=", "songs.id");
        $tracks->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $appends = [];
        if($q) {
            $tracks->where("songs.name", "like", $q."%")->orWhere('authors.name', "like", $q."%");
            $appends['q'] = $q;
        }
        $tracks->select("songs.name", "authors.name as author_name", "tracks.*");
        $json = $tracks->paginate(10)->appends($appends)->toArray();
        return json_encode($json);

    }
}