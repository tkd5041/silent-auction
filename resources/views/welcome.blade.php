<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Silent Auction</title>

    <link rel="icon" type="image/png" href="/favicon.ico" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="css/app.css">
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div>
                <img class="image-fluid title-image" src="img/sa-words.svg" alt="Silent Auction">
            </div>
            <div class="w-50 mx-auto my-3">
                <h4>If you’re coming to the auction for the first time, just click the “register” button above to set up your bidding name and see the items!</h4>
            </div>
            <div class="border border-success rounded m-3 p-3 w-50 mx-auto my-5">
                <h6 class="text-danger">To get the best view of the items, we suggest you view this on your computer use the Chrome Browser. <br>If
                    you’re on an iPhone, it works best if you make sure you’re updated to iOS 14. Have fun!</h6>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>