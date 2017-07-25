@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Search backing tracks</div>
                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-4 form-group">

                                    <label for="s-q">Song or artist name</label>
                                    <input class="form-control" id="s-q" name="q" value="{{$searchterm}}"/>

                                </div>
                                <div class="col-lg-2 form-group">
                                    <label>Type</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="" @if ($form_type == 'both') checked @endif> All backing tracks
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="guitar" @if ($form_type == 'guitar') checked @endif> Guitar backing tracks
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="drums" @if ($form_type == 'drums') checked @endif> Drums backing tracks
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 form-group">
                                    <label>Vocal</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="vocal" value="yes" @if ($form_vocal == 'yes') checked @endif> With vocal
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="vocal" value="no" @if ($form_vocal == 'no') checked @endif> Without vocal
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="vocal" value="" @if ($form_vocal == 'both') checked @endif> Both
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-1">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">


                    <div class="panel-body">
                        @include("frg/songs_list")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("search-term", $searchterm)
@section('title', $page_title)