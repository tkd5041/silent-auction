@extends('layouts.auction')

@section('content')

<div class="container" id="events">
    <div class="auction-header">
        <h4><b>{{ $event->name }}</b><br>
            <hr class="wd-50">
            <small><b>Starts: </b><span class="text-muted pl-4">{{ date('D, M j, Y ', strtotime($bids_start)) }} @
                    {{ date('g:i A', strtotime($bids_start)) }} (MST) </span></small><br>
            <small><b>End Time: </b><span class="text-muted pl-2">{{ date('D, M j, Y ', strtotime($bids_end)) }} @
                    {{ date('g:i A', strtotime($bids_end)) }} (MST) </span></small>
        </h4>

    </div> <!--  auction-header 1  -->
    <div class="auction-header float-right">
        <!--div>status: {{ $auction_status }} event: {{$event->active}}</div-->
        @if ($auction_status == 0)
        <div>
            <h4 class="text-muted ml-2">Auction Is: <span class="text-info">PENDING</span></h4>
            <div class="row py-2 justify-content-center">
                <div id="clockdiv">
                    <div>
                        <span class="days"></span>
                        <div class="smalltext">Days</div>
                    </div>
                    <div>
                        <span class="hours"></span>
                        <div class="smalltext">Hours</div>
                    </div>
                    <div>
                        <span class="minutes"></span>
                        <div class="smalltext">Minutes</div>
                    </div>
                    <div>
                        <span class="seconds"></span>
                        <div class="smalltext">Seconds</div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($auction_status == 1)
        <div>
            <h4 class="text-muted ml-2">Auction Is: <span class="text-success">OPEN</span></h4>
            <div class="row py-2 justify-content-center">
                <div id="clockdiv">
                    <div>
                        <span class="days"></span>
                        <div class="smalltext">Days</div>
                    </div>
                    <div>
                        <span class="hours"></span>
                        <div class="smalltext">Hours</div>
                    </div>
                    <div>
                        <span class="minutes"></span>
                        <div class="smalltext">Minutes</div>
                    </div>
                    <div>
                        <span class="seconds"></span>
                        <div class="smalltext">Seconds</div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($auction_status == 2)
        <div>
            <h4 class="text-muted ml-2">Auction Is: <span class="text-danger">CLOSED</span></h4>
            <div class="text-center">
                <a href='/pay/{{ $event->id }}/edit' class='btn btn-primary'>Pay Now</a>
            </div>
        </div>
        @endif
        <hr class="wd-50">
        <h5 class="float-right">Persons Online: <span class="badge badge-pill badge-warning mt-0">@{{ numberOfUsers }}
        </h5>
    </div> <!--  auction-header 1  -->
    <div class="container">
        <!--  container for item cards  -->
        <div class="row justify-content-center">
            <div class="card-deck">
                @if($auction_status == 1)
                <div class="card m-3 p-0" style="max-width: 16rem; min-width: 14rem;">
                    <div class="card-header">
                        <h5 class="card-title">Latest Bids</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Latest Ten Bids</h6>
                    </div>
                    <div class="card-body bids">
                        <current-bids></current-bids>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <small class="">Scroll To See More Bids</small>
                    </div>
                </div>
            </div>
            @endif
            @foreach($items as $item)
            <div class="card m-3 p-0" style="max-width: 16rem; min-width: 14rem;">
                <div class="card-header">
                    <h5 class="card-title">{{ Str::limit($item->title, 40) }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">(Retail Value: ${{ $item->retail_value }}.00)
                    </h6>
                </div>
                <div class="card-body d-flex flex-column">
                    @if(empty($item->image))
                    <div class="text-center md-4">
                        <h4 class="text-muted">No Image Available</h4>
                    </div>
                    @else
                    <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title}} image {{ $item->id }}" />
                    @endif
                    <hr />
                    <item-bid :item="{{ json_encode($item) }}" />
                </div>
                <div class="card-footer">
                    @if($item->sold == 0 && ($auction_status < 2)) <div class="text-center">
                        <a href="/auction/{{ $item->id }}/edit" class="btn btn-outline-primary view">View
                            Item</a>
                </div>
                @endif
                @if(($item->sold == 0 || $item->sold == 2) && $auction_status == 2)
                <div class="text-center sold">
                    <h5 class="text-info">Item Closed</h5>
                </div>
                @endif
                @if($item->sold == 1)
                <div class="text-center sold">
                    <img class="sold" src="/img/sold-stamp.png" alt="item sold">
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>
</div>



@endsection