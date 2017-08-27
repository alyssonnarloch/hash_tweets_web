<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/twitter.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app"></div>
        
        <!-- Javascript -->
        <script src="{{ asset('js/app.js') }}"></script>

        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    oi
                                </li>
                            </ul>
                        </li>                    
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">  
                <div class="col-sm-2">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li id="menu_ranking">
                            <a class="nav-link" href="{{ url('twitter/ranking') }}">Ranking</a>
                        </li>
                        <li id="menu_search">
                            <a class="nav-link" href="{{ url('twitter/search') }}">Busca</a>
                        </li>
                        <li id="menu_history">
                            <a class="nav-link" href="{{ url('twitter/history') }}">Histórico</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-10">              
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
