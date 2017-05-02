<?php
/**
 * Created by PhpStorm.
 * User: default
 * Date: 10.04.2017
 * Time: 23:10
 */

namespace App\Http\Controllers;


use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get("q");
        $songs = Song::where("songs.name", "like", $q . "%")->orWhere('authors.name', "like", $q . "%");
        $songs->orderBy("created_at", "DESC");
        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->leftJoin('tracks', 'tracks.song_id', '=', 'songs.id');
        $songs->groupBy("songs.id");
        $songs->select("songs.*", "authors.name as author_name", DB::raw("COUNT(tracks.id) as tcount"),
            DB::raw("SUM(tracks.bass) as bass"),
            DB::raw("SUM(tracks.drums) as drums"),
            DB::raw("SUM(tracks.vocals) as vocals"),
            DB::raw("SUM(tracks.lead) as lead"),
            DB::raw("SUM(tracks.rhythm) as rhythm"),
            DB::raw("SUM(tracks.keys) as 'keys'")
        );
        $songs->with("tabs");
        return view('search', [
            "songs" => $songs->paginate(20),
            "searchterm" => $q
        ]);

    }

    public function autocomplete($query, Request $request)
    {
        $json = [];
        if ($query) {
            $songs = Song::where("songs.name", "like", $query . "%")->orWhere('authors.name', "like", $query . "%");
            $songs->orderBy("created_at", "DESC");
            $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
            $songs->select("songs.*", "authors.name as author_name", DB::raw("CONCAT_WS(' ', songs.name, '-', authors.name) as name"));
            $json = $songs->get()->toArray();
        }
        return response()->json($json);
    }
}