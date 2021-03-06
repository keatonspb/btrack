<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="37d8443fdca267d6" />
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700&amp;subset=cyrillic" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href=​"/favicon.ico" type="image/x-icon">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!}; 
    </script>
</head>
<body>
<div class="wrapper">
    <div class="app_content">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">{{__('messages.toogle_navigation')}}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <i class="navbar-logo"></i><span>{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->

                    <div class="nav navbar-nav">
                            <form class="navbar-form" role="search" action="/search">
                                <div class="input-group">
                                    <input type="text" class="form-control suggest" autocomplete="off" style="width: 100%; float: none;" placeholder="Search" name="q" value="@yield('search-term')">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="/search?q=&type=guitar">For guitar</a></li>
                        <li><a href="/search?q=&type=drums">For drummers</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            {{--<li><a href="{{ route('login') }}">{{__('messages.add_backing_track')}}</a></li>--}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/cabinet/song/add"><i class="fa fa-plus" aria-hidden="true"></i> {{__('messages.add_backing_track')}}</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <footer>
        <div class="container">
            <div class="col-lg-10">
                <div class="disclamer">All original tracks and lyrics are property and copyright of their owners. Information on this page provided for educational purposes and personal use only.</div>
                <div class="contacts">
                    For any questions discodeprojects@gmail.com
                </div>
            </div>
            <div class="col-lg-2">
                <a target="_blank" href='https://play.google.com/store/apps/details?id=ru.discode.batrack&utm_source=web&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img  style="width: 100%;" alt='Get it on Google Play' src='https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png'/></a>
            </div>

        </div>

    </footer>
</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

@include("frg/counters")
</body>
</html>
