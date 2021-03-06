@extends('layouts.app')
@section('title', $song->name." - Edit backing song and tabs")
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
                                    <a class="btn btn-info btn-sm" href="/cabinet/track/edit/{{$track->id}}">Edit</a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Tabs
                        <div class="pull-right">
                            <button class="btn btn-primary btn-xs open_dialog" data-dialog="#edit_tab_dialog">Add tab
                            </button>
                        </div>
                    </div>
                    <div class="list-group">
                        @foreach($tabs as $tab)
                            <div class="list-group-item">
                                <strong>{{$tab->instrument}}</strong> {{$tab->tuning_name}}
                                <div class="pull-right">
                                    <button class="btn btn-info btn-xs open_dialog" data-dialog="#edit_tab_dialog"
                                            data-get="/cabinet/tabs/get/{{$tab->id}}">edit
                                    </button>
                                    <a class="btn btn-danger btn-xs open_dialog delete-item"
                                       href="/cabinet/tabs/{{$tab->id}}/delete">delete</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                    @include("dialogs.edit_tab_dialog")

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
