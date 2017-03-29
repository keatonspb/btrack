<?php

namespace App\Http\Controllers;

use App\Author;
use App\Song;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CabinetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addSong(Request $request)
    {

        return view('add');
    }

    public function editSong(Request $request, $id) {
        $song = Song::find($id);
        if(!$song) {
            abort(404);
        }
        return view('edit', [
            "song" => $song,
            "author" => $song->author,
            "tracks" => $song->tracks
        ]);
    }

    public function editTrack(Request $request, $id) {
        $track = Track::find($id);

        if(!$track) {
            abort(404);
        }
        $song = $track->song;
        return view('edit_track', [
            "song" => $song,
            "author" => $song->author,
            "tracks" => $song->tracks
        ]);
    }

    public function submitSong(Request $request) {
        $json = [
            "success" => true,
            "message" => "Song added"
        ];
        try {
            DB::beginTransaction();
            $song = Song::getOrCreate($request->get("name"), $request->get("author"));
            $row = [
                "status" => 1,
                "song_id" => $song->id,
                "user_id" => Auth::user()->id,
                "bass" => $request->get("bass", false),
                "drums" => $request->get("drums", false),
                "vocals" => $request->get("vocals", false),
                "lead" => $request->get("lead", false),
                "rhythm" => $request->get("rhythm", false),
                "keys" => $request->get("keys", false),
            ];
            $track = Track::create($row);
            $filename = $track->upload($request->file("track"));
            $track->filename = $filename;
            $track->save();
            $json['id'] = $song->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $json['success'] = false;
            $json['message'] = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
        return response()->json($json);
    }

    public function saveSong(Request $request) {
        $json = [
            "success" => true,
            "message" => "Song saved"
        ];
        try {
            DB::beginTransaction();
            $author = Author::getOrCreate($request->get("author"));
            $song = Song::find($request->get("id"));
            $song->name = $request->get("name");
            $song->author_id = $author->id;
            $song->save();
            $json['id'] = $song->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $json['success'] = false;
            $json['message'] = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
        return response()->json($json);
    }

    public function saveTrack(Request $request)
    {
        $json = [
            "success" => true,
            "message" => "Track saved"
        ];
        try {
            DB::beginTransaction();
            $author = Author::getOrCreate($request->get("author"));
            $row = [
                "status" => 1,
                "author_id" => $author->id,
                "user_id" => Auth::user()->id,
                "bass" => $request->get("bass", false),
                "drums" => $request->get("drums", false),
                "vocals" => $request->get("vocals", false),
                "lead" => $request->get("lead", false),
                "rhythm" => $request->get("rhythm", false),
                "keys" => $request->get("keys", false),
            ];
            if (!$id = $request->get("id")) {
                $track = Track::create($row);
                $track->upload($request->file("track"));
            } else {
                $track = Track::find($id);
                $track->update($row);
            }
            $json['id'] = $track->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $json['success'] = false;
            $json['message'] = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
        }
        return response()->json($json);
    }
}
