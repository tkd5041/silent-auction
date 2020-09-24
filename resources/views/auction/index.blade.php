<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="nav-img image-fluid" src="../img/sa-words.png" alt="silent auction">
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
<div class="container" id="events">
    <div class="auction-header">
        <h1>{{ $event->name }}</h1>
    </div>
    <div class="auction-details">
        <em>Start Date: </em>{{ $event->start_date }} <em>Start Time: </em>{{ $event->start_time }} 
        <em>End Date: </em>{{ $event->end_date }} <em>End Time: </em>{{ $event->end_time }}
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Current Bids</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach($items as $item)
                            <hr>
                            <div>
                                <h4>{{ $item->title }}</h4>
                            </div>
                            <div>Value: {{ $item->value }} </div>
                            @if($item->current_bid == 0)
                                <div>Minimum Bid: ${{ $item->initial_bid }}</div>
                                <button id="modalActivate" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalPreview">
                                    Enter Bid
                                </button>
                            @else
                                <div>Current Bid: ${{ $item->current_bid }}</div>
                                <div>Minimum Bid: ${{ $item->current_bid + $item->increment }}</div>
                                <button id="modalActivate" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalPreview">
                                    Enter Bid
                                </button>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($bids as $bid)
                            <hr>
                            <div>
                                <h4>{{ $bid->title }}</h4>
                            </div>
                            <div>{{ $bid->username }} bid ${{ $bid->current_bid }}</div>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>

</div>
</div>
</main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script>
Echo.channel('auction')
    .listen('NewMessage', (e) => {
        console.log(e.message);
    })

</script>
<!--script src="https://code.jquery.com/jquery-3.5.1.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script-->
</body>
<script>
$(".alert").fadeTo(5000, 750).slideUp(750, function () {
$(".alert").slideUp(750);
});

</script>

</html>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade left" id="exampleModalPreview" tabindex="-1" role="dialog"
aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-top" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Enter Bid for {{ $item->title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="container">
            <div><blockquote>{{ $item->description }}</blockquote></div>
            <div class="gallery">
                <img class="item" src="https://source.unsplash.com/random/320x240" alt="Example image">
                <img class="item" src="https://source.unsplash.com/random/320x240" alt="Example image">
                <img class="item" src="https://source.unsplash.com/random/320x240" alt="Example image">
                <img class="item" src="https://source.unsplash.com/random/320x240" alt="Example image">
             </div>
            <div>Value: {{ $item->value }}</div>
               @if($item->current_bid == 0)
                <div>Minimum Bid: ${{ $item->initial_bid }}</div>
               @else
                <div>Current Bid: ${{ $item->current_bid }}</div>
                <div>Minimum Bid: ${{ $item->current_bid + $item->increment  }}</div>
               @endif
        </div>
        <div>
            <input type="number" name="new_bid" id="new_bid">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit Bid</button>
    </div>
</div>
</div>
</div>
<!-- Modal -->

