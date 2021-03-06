<?php

namespace App\Http\Controllers;

use App\Author;
use App\Song;
use App\Tab;
use App\Track;
use App\Tuning;
use Illuminate\Http\JsonResponse;
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

    public function editSong(Request $request, $id)
    {
        $song = Song::find($id);
        if (!$song) {
            abort(404);
        }

        return view('edit', [
            "song" => $song,
            "author" => $song->author,
            "tracks" => $song->tracks,
            "tunings" => Tuning::all(),
            "tabs" => $song->tabs()->leftJoin('tunings', 'tunings.id', '=', 'tabs.tuning_id')->select("tabs.*", "tunings.name as tuning_name")->get()

        ]);
    }

    public function editTrack(Request $request, $id)
    {
        $track = Track::find($id);

        if (!$track) {
            abort(404);
        }
        $song = $track->song;
        return view('edit_track', [
            "song" => $song,
            "author" => $song->author,
            "track" => $track,
            "cues" => $track->getCues(),
            "acues" => Track::CUES
        ]);
    }

    public function deleteTrack(Request $request, $track_id) {
        $json = ['success' => true];
        try {
            $Track = Track::findOrFail($track_id);
            if($Track->user_id != Auth::user()->id) {
                throw new \Exception("You cannot delete track");
            }
            $Track->delete();
        } catch (\Exception $e) {
            $json['success'] = false;
            $json['message'] = $e->getMessage();
        }
        return new JsonResponse($json);

    }

    public function submitSong(Request $request)
    {
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
            $json['message'] = $e->getMessage() . " " . $e->getFile() . " " . $e->getLine();
        }
        return response()->json($json);
    }

    public function saveSong(Request $request)
    {
        $json = [
            "success" => true,
            "message" => "Song saved"
        ];
        try {
            DB::beginTransaction();
            if(!Auth::user()->super) {
                throw new \Exception("You cannot edit song");
            }
            $song = Song::find($request->get("id"));

            if($request->get("name")) {
                $song->name = $request->get("name");
                $author = Author::getOrCreate($request->get("author"));
                $song->author_id = $author->id;
            }

            $song->save();
            $json['id'] = $song->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $json['success'] = false;
            $json['message'] = $e->getMessage();
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

            if (!$request->get("id")) {
                throw new \Exception("Bad request");
            }

            $track = Track::findOrFail($request->get("id"));

            if($track->user_id != Auth::user()->id) {
                throw new \Exception("You cannot edit this track");
            }
            $track->bass = $request->get("bass", false);
            $track->drums = $request->get("drums", false);
            $track->vocals = $request->get("vocals", false);
            $track->lead = $request->get("lead", false);
            $track->rhythm = $request->get("rhythm", false);
            $track->keys = $request->get("keys", false);
            $props = [];
            $cues = [];
            foreach (array_keys(Track::CUES) as $cue) {
                foreach ($request->get($cue, []) as $time) {
                    $cues[] = [
                        "name" => $cue,
                        "perc" => $time
                    ];
                }
            }
            $props['cues'] = $cues;
            $track->properties = json_encode($props);
            $track->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $json['success'] = false;
            $json['message'] = $e->getMessage() . " " . $e->getFile() . " " . $e->getLine();
        }
        return response()->json($json);
    }

}
