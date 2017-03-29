@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{$song->name}} - {{$author->name}}</div>
                <div class="panel-body">
                    <div class="player">
                        <audio src="{{$file}}" controls />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">Track info</div>
                <div class="panel-body">
                            <div class="form-group">
                                <label>Name</label>
                                <div class="form-control-static">{{$song->name}}</div>
                            </div>
                            <div class="form-group">
                                <label>Artist name</label>
                                <div class="form-control-static">{{$author->name}}</div>
                            </div>
                        <div>
                        </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Alternative tracks</div>

            </div>
        </div>
    </div>
</div>
@endsection
