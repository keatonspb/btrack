<?php

namespace App\Http\Controllers;

use App\Tab;
use App\Track;
use Illuminate\Http\Request;

class TabController extends Controller
{
    public function save(Request $request) {
        $json = ["success"=>true, "message"=>"Tab saved"];
        try {
            $row = [
                "song_id" => $request->get("song_id"),
                "instrument" => $request->get("instrument"),
                "tuning_id" => $request->get("tuning_id"),
                "content" => $request->get("content"),
            ];
            Tab::updateOrCreate($row);
        } catch (\Exception $e) {
            $json['message'] = $e->getMessage();
            $json['success'] = false;
        }
        return json_encode($json);
    }

    public function delete(Request $request) {

    }
}
