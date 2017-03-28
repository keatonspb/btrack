<?php

namespace App\Http\Controllers;

use App\Author;
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
    public function addTrack(Request $request)
    {

        return view('add');
    }

    public function editTrack(Request $request, $id) {
        $track = Track::find($id);
        $author = $track->author;
        return view('edit', [
            "track" => $track,
            "author" => $track->author,
            "path" => $track->getFilePath(),
        ]);
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
                "name" => $request->get("name"),
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
