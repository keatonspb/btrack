@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Search backing tracks</div>

                <div class="panel-body">
                    @include("frg/songs_list")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("search-term", $searchterm)
@section('title', 'Search for '. $searchterm .' Guitar, Drums backtracks and tabs for free')