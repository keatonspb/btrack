@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Tracks</div>
                    <div class="panel-body">
                        @foreach($tracks as $track)
                            <div class="row">
                                <div class="col-sm-6">
                                    @include("frg/player", ['file'=>$track->getFilePath(), 'class'=>'sm'])
                                </div>
                                <div class="col-sm-4">
                                    @include('frg/instruments', ['track'=>$track])
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-info btn-sm" href="/cabinet/track/edit/{{$track->id}}" >Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Tabs</div>
                    <form action="/cabinet/song/save" class="ajax-form">
                    <div class="panel-body">
                        <input type="hidden" name="id" value="{{$song->id}}">
                        <textarea class="form-control" name="tabs"></textarea>
                    </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Song info</div>
                    <form method="post" action="/cabinet/song/save" class="ajax-form"
                          enctype="multipart/form-data">
                    <div class="panel-body">
                            <input type="hidden" name="id" value="{{$song->id}}">
                            <div class="alert alert-danger" style="display: none"></div>
                            <div class="alert alert-success" style="display: none"></div>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" value="{{$song->name}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Artist name</label>
                                <input class="form-control" name="author" value="{{$author->name}}" required/>
                            </div>

                    </div>
                    <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Save</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
