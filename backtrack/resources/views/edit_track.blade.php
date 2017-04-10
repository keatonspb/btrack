@extends('layouts.app')
@section('title', $song->name." - Edit backing track")
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$song->name}} - {{$author->name}}
                    <div class="pull-left"></div>
                    </div>
                    <div class="panel-body">
                        @include("frg/player", ['class'=>'editable'])
                        @include("dialogs.edit_cue_dialog")
                    <form action="/cabinet/track/save" class="edit_track_form" method="post">
                        {{ csrf_field() }}
                        <input name="id" type="hidden" value="{{$track->id}}" />
                        <div class="cue_container">
                            @foreach($track->getCues() as $cue)
                                <input id="cue_{{$loop->index}}" name="{{$cue->name}}[]" value="{{$cue->perc}}" type="hidden" />
                            @endforeach
                        </div>
                        <div class="checkbox-inline "><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox"  name="bass" value="1" @if($track->bass) checked @endif> bass</label></div>
                        <div class="checkbox-inline"><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox" name="drums" value="1" @if($track->drums) checked @endif> drums</label></div>
                        <div class="checkbox-inline"><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox" name="vocals" value="1" @if($track->vocals) checked @endif> vocals</label></div>
                        <div class="checkbox-inline"><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox" name="lead" value="1" @if($track->lead) checked @endif> lead guitar</label></div>
                        <div class="checkbox-inline"><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox" name="rhythm" value="1" @if($track->rhythm) checked @endif> rhythm guitar</label></div>
                        <div class="checkbox-inline"><label><input class="edit_instrument" data-id="{{$track->id}}" type="checkbox" name="keys" value="1" @if($track->keys) checked @endif> keys</label></div>
                        <div>
                            <button class="btn btn-primary">Save</button>
                            <div class="pull-right">
                                <a class="btn btn-danger delete-item" href="/cabinet/track/delete/{{$track->id}}" data-backurl="/cabinet/song/edit/{{$track->song_id}}">Delete</a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
