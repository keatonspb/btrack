@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$song->name}} - {{$author->name}}</div>
                    <div class="panel-body">
                        @include("frg/player", ['class'=>''])
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Song info</div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-sm-4">Name</label>
                            <div class="col-sm-6">{{$song->name}}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Artist name</label>
                            <div class="col-sm-6">{{$author->name}}</div>
                        </div>
                        <a class="btn btn-info btn-sm" href="/cabinet/song/edit/{{$song->id}}">Edit</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Alternative tracks</div>

                </div>
            </div>
        </div>
    </div>
@endsection
