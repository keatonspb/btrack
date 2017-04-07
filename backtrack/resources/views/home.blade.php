@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Last added</div>

                <div class="panel-body">
                    @include("frg/songs_list")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('title', 'Guitar, Drums backtracks and tabs for free')