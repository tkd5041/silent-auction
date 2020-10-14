<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Optimal Internet Explorer compatibility -->
    <title>{{ config('app.name', 'SilentAuction') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


    <link rel="icon" type="image/png" href="/favicon.ico" />
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASIpb5zQz5l2RNLQ0bFC4kWryOSXW3IufghNZ_QrmKpXavHg6_HYjY3PkNrNeGNVDVxMVsmlYLf1VE3F&disable-funding=credit">
    </script>
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
                                <a href="{{ route('sms.index') }}" class="dropdown-item">
                                    SMS
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
    $(".alert").fadeTo(5000, 750).slideUp(750, function() {
        $(".alert").slideUp(750);
    });
    </script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

    
<script>
    var $url = '/pay/{{ $event->id }}/response';
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: {{ $total }}
                    }
                }],
                application_context: {
                }
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = $url;
            });
        }
    }).render('#paypal-button-container'); // Display payment options on your web page
    </script>
</body>

</html>