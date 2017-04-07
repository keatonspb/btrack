@extends('layouts.app')
@section('title', "Add backing track and tabs")
@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add track </div>

                <div class="panel-body">

                    <form method="post" action="/cabinet/song/submit" class="track-form" enctype="multipart/form-data">
                        <div class="alert alert-danger" style="display: none"></div>
                        <div class="alert alert-success" style="display: none"></div>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Name</label>
                                <input class="form-control" name="name" required />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Artist name</label>
                                <input class="form-control" name="author" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <div class="checkbox-inline "><label><input type="checkbox" name="bass" value="1" checked> bass</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="drums" value="1" checked> drums</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="vocals" value="1" checked> vocals</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="lead" value="1" checked> lead guitar</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="rhythm" value="1" checked> rhythm guitar</label></div>
                                <div class="checkbox-inline"><label><input type="checkbox" name="keys" value="1" checked> keys</label></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Файл</label>
                            <input type="file" name="track" required>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary btn-block">Добавить</button>
                            </div>
                            <div class="col-lg-10">
                                <div class="progress" style="display: none">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
