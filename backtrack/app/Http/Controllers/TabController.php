<?php

namespace App\Http\Controllers;

use App\Tab;
use App\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $request) {
        $json = ["success"=>true, "message"=>"Tab saved"];
        try {
            if(!Auth::user()->super) {
                throw new \Exception("You cannot add tabs");
            }
            $row = [
                "song_id" => $request->get("song_id"),
                "instrument" => $request->get("instrument"),
                "tuning_id" => $request->get("tuning_id") ? $request->get("tuning_id") : null,
                "content" => $request->get("content"),
                "id" => null,
            ];

            if($request->get("id", null)) {
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
            if(!Auth::user()->super) {
                throw new \Exception("You cannot add tabs");
            }
            $tab = Tab::findOrFail($id);
            $tab->delete();
        } catch (\Exception $e) {
            $json['success'] = false;
            $json['message'] = $e->getMessage();
        }
        return json_encode($json);
    }
}
