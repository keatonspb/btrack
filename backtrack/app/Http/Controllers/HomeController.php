<?php

namespace App\Http\Controllers;

use App\Song;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    const SEARCH_EXAMPLES = [
        'Smells Like Teen Spirit',
        'How You Remind Me',
        'Everlong',
        'Foo Fighters',
        'Green Day',
        'Metallica',
        'U2',
        'AC/DC',
        'Iron Maiden'
    ];
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
        $tracks_count = Track::where("status", "=", "1")->count();

        $songs = Song::orderBy("created_at", "DESC");

        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->leftJoin('tracks', 'tracks.song_id', '=', 'songs.id');
        $songs->groupBy("songs.id");
        $songs->select("songs.*", "authors.name as author_name", "authors.alias as author_alias", DB::raw("COUNT(tracks.id) as tcount"),
            DB::raw("SUM(tracks.bass) as bass"),
            DB::raw("SUM(tracks.drums) as drums"),
            DB::raw("SUM(tracks.vocals) as vocals"),
            DB::raw("SUM(tracks.lead) as lead"),
            DB::raw("SUM(tracks.rhythm) as rhythm"),
            DB::raw("SUM(tracks.keys) as 'keys'")
            );
        $songs->with("tabs");

        return view('home', [
            "songs" => $songs->paginate(20),
            "tracks_count" => $tracks_count,
            "search_example" => self::SEARCH_EXAMPLES[array_rand(self::SEARCH_EXAMPLES)],
        ]);
    }

    public function song($artist_alias, $song_alias = null, $track_id = null, Request $request) {
        if(is_numeric($artist_alias)) {
            $song = Song::find($artist_alias);
            return redirect($song->getHref(), 301);
        } else {
            $song = Song::where("alias", $song_alias)->first();
        }

        if(!$song) {
            abort(404);
        }
        if($track_id) {
            $track = Track::find($track_id);
        } else {
            $track = $song->tracks->first();
        }
        if(!$track) {
            abort(404);
        }

        $tabsCol = $song->tabs()->leftJoin('tunings', 'tunings.id', '=', 'tabs.tuning_id')->select("tabs.*", "tunings.name as tuning_name", "tunings.strings as tuning_strings")->get();
        $tabs = [];
        $tabs_instruments = [];
        foreach ($tabsCol as $tab) {
            if(!isset($tabs_instruments[$tab->instrument])) {
                $tabs_instruments[$tab->instrument] = [
                    "name" => $tab->instrument,
                    "count_tabs" => 0,
                    "tabs" => []
                ];
            }
            $tab->content = str_replace("\n", "<br>", $tab->content);
            $tabs_instruments[$tab->instrument]['tabs'][] = $tab;
            $tabs_instruments[$tab->instrument]['count_tabs']++;
        }
        return view('view', [
            "song" => $song,
            "author" => $song->author,
            "track" => $track,
            "alttracks" => $track->getAlternativeTracks(),
            "tabs_instruments" => $tabs_instruments,

        ]);
    }

    /**
     * Оценка трэка
     * @param $track
     * @param Request $request
     * @return JsonResponse
     */
    public function rate($track, Request $request) {
        $json = ['success' => true];
        $cookie = cookie('uniqueId', '');
        try {
            $user_key = $request->cookie("uniqueId");


            $track = Track::findOrFail($track);
            /* @var $track \App\Track */
            $track->rate($request->get("rate", 0), $user_key);
        } catch (\Exception $e) {
            $json['success'] = false;
            $json['message'] = $e->getMessage();
        }
        return response()->json($json)->cookie($cookie);
    }


}
