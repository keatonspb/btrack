<?php

namespace App\Http\Controllers;

use App\Song;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::orderBy("created_at", "DESC");

        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->leftJoin('tracks', 'tracks.song_id', '=', 'songs.id');
        $songs->groupBy("songs.id");
        $songs->select("songs.*", "authors.name as author_name", DB::raw("COUNT(tracks.id) as tcount"),
            DB::raw("SUM(tracks.bass) as bass"),
            DB::raw("SUM(tracks.drums) as drums"),
            DB::raw("SUM(tracks.vocals) as vocals"),
            DB::raw("SUM(tracks.lead) as lead"),
            DB::raw("SUM(tracks.rhythm) as rhythm"),
            DB::raw("SUM(tracks.bass) as bass")
            );
        return view('home', [
            "songs" => $songs->paginate(20)
    ]);
    }

    public function song($id, $track_id = null, Request $request) {
        $song = Song::find($id);
        if(!$song) {
            abort(404);
        }
        if($track_id) {
            $track = Track::find($track_id);
        } else {
            $track = $song->tracks->first();
        }



        return view('view', [
            "song" => $song,
            "author" => $song->author,
            "track" => $track,
            "alttracks" => $track->getAlternativeTracks(),

        ]);
    }
}
