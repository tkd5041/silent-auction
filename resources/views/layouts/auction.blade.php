<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-12">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PAL Auction') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='shortcut icon' href='/favicon.ico' type='image/x-icon' />
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="https://pal-auction.org/home">
                    <img class="nav-img image-fluid" src="../../../img/sa-words.png" alt="silent auction">
                    <span class="current_event">➢ {{ session('event_name') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if(Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{ route('home') }}" class="dropdown-item">
                                    Home
                                </a>
                                @if(session('selected_event'))
                                <a href="{{ route('auction', session('selected_event')) }}" class="dropdown-item">
                                    Auction
                                </a>
                                @endif

                                @can('manage-users')
                                <a href="{{ route('admin.donors.index') }}" class="dropdown-item">
                                    Donors
                                </a>
                                <a href="{{ route('admin.events.index') }}" class="dropdown-item">
                                    Events
                                </a>
                                <a href="{{ route('admin.items.index') }}" class="dropdown-item">
                                    Items
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="dropdown-item">
                                    Users
                                </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @include('partials.alerts')
                    </div>
                </div>
                @yield('content')
            </div>
            <!--div>Now: {{ $dt_nw }} | Date: {{date('m-d-Y H:i:s', $dt_nw) }}</div>
            <div>Start: {{ $dt_st }} | Date: {{date('m-d-Y H:i:s', $dt_st) }}</div>
            <div>Stop {{ $dt_sp }} | Date: {{date('m-d-Y H:i:s', $dt_sp) }}</div>
            <div>Diff St {{ ($dt_st - $dt_nw) * 60 }}</div>
            <div>Diff Sp {{ ($dt_sp - $dt_nw) * 60 }}</div-->
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>
    <script>
    $(".alert").fadeTo(5000, 750).slideUp(750, function() {
        $(".alert").slideUp(750);
    });
    </script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

    <script type="text/javascript">
    var cur_status = '';
    var dt_st = {{ $dt_st }};
    var dt_sp = {{ $dt_sp }};
    var dt_nw = {{ $dt_nw }};
    // console.log('dt_nw: ', dt_nw);
    // console.log('dt_st: ', dt_st);
    // console.log('dt_sp: ', dt_sp);
    // console.log('if: ', (dt_st - dt_nw) / 60);
    // console.log('elseif: ', (dt_sp - dt_nw) / 60);
    if( dt_nw < dt_st )
    {
        dt_df = (dt_st - dt_nw) / 60;
        cur_status = 'The Auction Has Opened!'
        console.log('if-dt_df: ', dt_df);
    }
    else if(dt_nw > dt_st && dt_nw < dt_sp)
    {
        dt_df = (dt_sp - dt_nw) / 60 ;
        cur_status = 'The Auction Has Ended!'
        console.log('elseif-dt_df: ', dt_df);
    }
    else
    {
        $("#clockdiv").remove();
    }
    
    var timeInMinutes = dt_df;
        var currentTime = Date.parse(new Date());
        var deadline = new Date(currentTime + timeInMinutes * 60 * 1000);


        function getTimeRemaining(endtime) {
            var t = Date.parse(endtime) - Date.parse(new Date());
            var seconds = Math.floor((t / 1000) % 60);
            var minutes = Math.floor((t / 1000 / 60) % 60);
            var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
            var days = Math.floor(t / (1000 * 60 * 60 * 24));
            return {
                'total': t,
                'days': days,
                'hours': hours,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        function initializeClock(id, endtime) {
            var clock = document.getElementById(id);
            function updateClock() {
                var t = getTimeRemaining(endtime);
                var daysSpan = clock.querySelector('.days');
                var hoursSpan = clock.querySelector('.hours');
                var minutesSpan = clock.querySelector('.minutes');
                var secondsSpan = clock.querySelector('.seconds');
                daysSpan.innerHTML = t.days;
                hoursSpan.innerHTML = t.hours;
                minutesSpan.innerHTML = t.minutes;
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
                if (t.total <= 1 && t.total >= 0) {
                    // Redirect if the Countdown is Over
                    alert(cur_status);
                    window.location.reload();
                }

            }

            updateClock(); // run function once at first to avoid delay
            var timeinterval = setInterval(updateClock, 1000);
        }

        initializeClock('clockdiv', deadline);
    </script>

</body>

</html>