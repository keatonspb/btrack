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
                "tuning_id" => $request->get("tuning_id") ? $request->get("tuning_id") : null,
                "content" => $request->get("content"),
            ];
            if($request->get("id")) {
                $row['id'] = $request->get("id");
            }
            Tab::updateOrCreate(['id'=>$row['id']],$row);
        } catch (\Exception $e) {
            $json['message'] = $e->getMessage();
            $json['success'] = false;
        }
        return json_encode($json);
    }

    public function get($id, Request $request) {
        $json = ['success'=>true];
        try {
            $tab = Tab::findOrFail($id);
            $json['data'] = $tab->toArray();
        } catch (\Exception $e) {
            $json['success'] = false;
            $json['message'] = $e->getMessage();
        }
        return json_encode($json);
    }
    public function delete($id, Request $request) {
        $json = ['success'=>true];
        try {
            $tab = Tab::findOrFail($id);
            $tab->delete();
        } catch (\Exception $e) {
            $json['success'] = false;
            $json['message'] = $e->getMessage();
        }
        return json_encode($json);
    }
}
