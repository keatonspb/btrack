<?php
/**
 * Created by PhpStorm.
 * User: Keaton
 * Date: 31.07.2017
 * Time: 12:41
 */

namespace App\Http\Controllers;


use App\Author;
use App\Song;
use App\Track;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AuthorController extends Controller
{
    public function index($artist_alias, Request $request) {
        $author = Author::where("alias", "=", $artist_alias)->firstOrFail();

        $songs = Track::where("author_id", "=", $author->id);

        $songs->orderBy("tracks.rating", "DESC")->orderBy("tracks.created_at", "DESC");
        $songs->leftJoin('songs', 'tracks.song_id', '=', 'songs.id');
        $songs->leftJoin('authors', 'songs.author_id', '=', 'authors.id');
        $songs->select("songs.*", "authors.name as author_name", "authors.alias as author_alias", "tracks.*");
        $songs->with("tabs");
        return view('author', [
            "songs" => $songs->paginate(20),
            "author_name" => $author->name,
        ]);
    }
}