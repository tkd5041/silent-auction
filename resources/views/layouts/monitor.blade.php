<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-12">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SilentAuction') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="nav-img image-fluid" src="../../../img/sa-words.png" alt="silent auction">
                    @if(session('event_name'))
                        <span class="current_event">➢ {{ session('event_name') }}</span>
                    @endif
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
                                <a class="nav-link"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
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
                                        <a href="{{ route('admin.donors.index') }}"
                                            class="dropdown-item">
                                            Donors
                                        </a>
                                        <a href="{{ route('admin.events.index') }}"
                                            class="dropdown-item">
                                            Events
                                        </a>
                                        <a href="{{ route('admin.items.index') }}"
                                            class="dropdown-item">
                                            Items
                                        </a>
                                        <a href="{{ route('admin.users.index') }}"
                                            class="dropdown-item">
                                            Users
                                        </a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}"
                                        method="POST" style="display: none;">
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
                    <div class="col-md-10">
                        @include('partials.alerts')
                    </div>
                </div>
                @yield('content')
            </div>
            
        </main>
    </div>
        <!--script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
        </script-->
        <script src="{{ asset('js/app.js') }}"></script>
        
        <script>
            $(".alert").fadeTo(5000, 750).slideUp(750, function () {
                $(".alert").slideUp(750);
            });

        </script>

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

        </script>

        <script>
            window.setInterval('refresh()', 3000); 	// Call a function every 10000 milliseconds (OR 10 seconds).

            // Refresh or reload page.
            function refresh() {
                var ref = ref++;
                window .location.reload();
            }
        </script>

        <script>
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
                var daysSpan = clock.querySelector('.days');
                var hoursSpan = clock.querySelector('.hours');
                var minutesSpan = clock.querySelector('.minutes');
                var secondsSpan = clock.querySelector('.seconds');

                function updateClock() {
                    var t = getTimeRemaining(endtime);

                    daysSpan.innerHTML = t.days;
                    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
                    
                    

                    if (t.total <= 0) {
                    clearInterval(timeinterval);
                    location.reload();
                    }
                }

                updateClock();
                var timeinterval = setInterval(updateClock, 1000);
                }

                var dNow = {{$dt_now}};
                var dStart = {{$dt_st}};
                var dEnd = {{$dt_sp}};
                
                if (dNow < dStart)
                {
                    var deadline = new Date(Date.parse('{{ $bids_start }}'));

                }
                else if (dNow > dStart && dNow < dEnd)
                {
                    var deadline = new Date(Date.parse('{{ $bids_end }}'));
                } 
                
                initializeClock('clockdiv', deadline);
        </script>
        
</body>



</html>
