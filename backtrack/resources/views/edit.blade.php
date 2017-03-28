@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">Track data</div>
                <div class="panel-body">
                {{$path}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">Track info</div>
                <div class="panel-body">
                    <form method="post" action="/cabinet/save" class="track-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$track->id}}">
                        <div class="alert alert-danger" style="display: none"></div>
                        <div class="alert alert-success" style="display: none"></div>
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" value="{{$track->name}}" required />
                            </div>
                            <div class="form-group">
                                <label>Artist name</label>
                                <input class="form-control" name="author"  value="{{$author->name}}" required />
                            </div>

                                <div class="checkbox "><label><input type="checkbox" name="bass" value="1" @if($track->bass) checked @endif> bass</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="drums" value="1"  @if($track->drums) checked @endif> drums</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="vocals" value="1"  @if($track->vocals) checked @endif> vocals</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="lead" value="1"  @if($track->lead) checked @endif> lead guitar</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="rhythm" value="1"  @if($track->rhythm) checked @endif> rhythm guitar</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="keys" value="1"  @if($track->keys) checked @endif> keys</label></div>

                        <div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
