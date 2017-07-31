@extends('layouts.app')
@section('title', $song->name . " ". $author->name . " backing track and tabs")
@section('description', 'Free guitar backing track for '.$song->name . " - ". $author->name )
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$song->name}} - <a href="/song/{{$author->alias}}">{{$author->name}}</a>
                        @if(Auth::check() && Auth::user()->id == $track->user_id)
                        <div class="pull-right">
                            <a class="btn btn-info btn-xs" href="/cabinet/track/edit/{{$track->id}}">Edit track</a>
                        </div>
                        @endif
                    </div>
                    <div class="panel-body">
                        @include("frg/player", ['class'=>''])
                    </div>
                    <div class="panel-footer">
                        @include('frg/instruments', ['track'=>$track])
                        <div class="pull-right">
                        @include('frg/rating', ['track'=>$track])
                        </div>
                    </div>
                </div>
                @if($tabs_instruments)
                @include("frg/tabs")
                    @endif
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Song info
                        @if(Auth::check() && Auth::user()->super)
                        <div class="pull-right"><a class="btn btn-info btn-xs" href="/cabinet/song/edit/{{$song->id}}">Edit
                                song</a></div>
                            @endif
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-sm-4">Name</label>
                            <div class="col-sm-6">{{$song->name}}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Artist name</label>
                            <div class="col-sm-6">{{$author->name}}</div>
                        </div>

                    </div>
                </div>
                @if($alttracks->count())
                    <div class="panel panel-default">
                        <div class="panel-heading">Alternative tracks</div>
                        <ul class="list-group">
                            @foreach($alttracks as $alttrack)
                                <li class="list-group-item">
                                    <a href="/song/{{$author->alias}}/{{$song->alias}}/{{$alttrack->id}}">
                                        @include('frg/instruments', ['track'=>$alttrack])
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
