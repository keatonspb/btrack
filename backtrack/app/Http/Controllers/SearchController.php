<?php
/**
 * Created by PhpStorm.
 * User: default
 * Date: 10.04.2017
 * Time: 23:10
 */

namespace App\Http\Controllers;


use App\Song;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get("q");
        $title = "Search for ". $q ." in {type} and tabs for free";
        if(!$q) {
            $title = "All {type} and tabs for free";
        }

        $songs = Track::where(function ($query) use ($q) {
            $query->where("songs.name", "like", $q . "%")->orWhere('authors.name', "like", $q . "%");
        });
        $songs->orderBy("tracks.rating", "DESC")->orderBy("tracks.created_at", "DESC");
        $songs->leftJoin('songs', 'tracks.song_id', '=', 'songs.id');
        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->select("songs.*", "authors.name as author_name", "authors.alias as author_alias", "tracks.*");
//        $songs->with("song");

        if($type = $request->get("type")) {
            switch ($type) {
                case "guitar":
                    $songs->where(function ($query) {
                        $query->where("tracks.lead", "=", 0)->orWhere("tracks.rhythm", "=", 0);
                    });
                    $title = str_replace("{type}", "guitar backing tracks", $title);
                    break;
                case "drums":
                    $songs->where("tracks.drums", "=", 0);
                    $title = str_replace("{type}", "drums backing tracks", $title);
                    break;
            }
        } else {
            $title = str_replace("{type}", "guitar and drums backing tracks", $title);
            $type = "both";
        }

        if($vocal = $request->get("vocal")) {
            switch ($vocal) {
                case "yes":
                    $songs->where("tracks.vocals", "=", 1);
                    break;
                case "no":
                    $songs->where("tracks.vocals", "=", 0);
                    break;
            }
        } else {
            $vocal = "both";
        }

        return view('search', [
            "songs" => $songs->paginate(20),
            "searchterm" => $q,
            "form_type" => $type,
            "form_vocal" => $vocal,
            "page_title" => $title,
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