@extends('layouts.auction')

@section('content')

<div class="container" id="events">
    <div class="auction-header">
        <h4><b>{{ $event->name }}</b><br><br>
            <small><b>Starts: </b><span class="text-muted pl-4">{{ date('D, M j, Y ', strtotime($bids_start)) }} @
                    {{ date('g:i A', strtotime($bids_start)) }} (MST) </span></small><br>
            <small><b>End Time: </b><span class="text-muted pl-2">{{ date('D, M j, Y ', strtotime($bids_end)) }} @
                    {{ date('g:i A', strtotime($bids_end)) }} (MST) </span></small>
        </h4>

    </div> <!--  auction-header 1  -->
    <div class="auction-header float-right">
        <div>
            @if($dt_now < $dt_st)
            <h4 class="text-muted ml-2">Auction Is: <span class="text-info">VIEWING ONLY</span></h4>
            @elseif($dt_now >= $dt_sp)
            <h4 class="text-muted ml-2">Auction Is: <span class="text-danger">CLOSED</span></h4>
            <div class="text-center">
                <a href='/pay/{{ $event->id }}/edit' class='btn btn-primary'>Pay Now</a>
            </div>
            @else
            <h4 class="text-muted ml-2">Auction Is: <span class="text-success">OPEN</span></h4>
            @endif
            <div>
            <h5 class="text-muted float-right">Bidders Online: <span class="badge badge-pill badge-success mt-0 mr-2">@{{ numberOfUsers }}</span></h5>
            </div>

        </div>
    </div> <!--  auction-header timer and pay button  -->
    <div class="container">
        <!--  container for item cards  -->
        <div class="row  row-cols-sm-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
            <!-- first card is latest bids -->
            @if($dt_now > $dt_st && $dt_now < $dt_sp)
            <div class="col mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Latest Bids</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Five Most Recent Bids)</h6>
                    </div>
                    <div class="card-body">
                        <current-bids></current-bids>
                    </div>
                </div>
            </div>
            @endif
            <!--  end of latest bids -->

            <!--  begin loop of items -->
            @foreach($items as $item)
            <div class="col mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ Str::limit($item->title, 40) }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Retail Value: ${{ $item->retail_value }}.00)</h6>
                    </div>

                    <!-- card body start -->
                    <div class="card-body">

                        @if(empty($item->image))
                        <div class="text-center my-4">
                            <h4 class="text-muted">No Image Available</h4>
                        </div>
                        @else
                        <img src="{{ $item->image }}" class="card-img-top"
                            alt="{{ $item->title}} image {{ $item->id }}" />
                        @endif

                        <hr />

                        @if($item->current_bid == 0)
                        <p>
                            <div>
                                <b>Minimum Bid: </b> <span class="text-danger mr-2 float-right">${{ $item->initial_bid }}.00</span>
                            </div>
                        </p>
                        @else
                        <p>
                            <div>
                                <b>Bidder: </b><span class="text-muted mr-1 float-right"><mark> {{ $item->username }}</mark></span>
                            </div>
                            <div>
                                <b>Current Bid: </b><span class="text-success mr-2 float-right">${{ $item->current_bid }}.00</span>
                            </div>
                            <div>
                                <b>Minimum Next Bid: </b><span class="text-danger mr-2 float-right">${{ $item->current_bid + $item->increment }}.00</span>
                            </div>
                        </p>
                        @endif

                    </div> 
                    <!-- card body end -->

                    <!-- card footer start -->
                    <div class="card-footer">

                        @if(($item->sold == 0 || $item->sold == 2) && $auction_closed == 1)
                        <div class="text-center sold">
                            <h5 class="text-info">Item Closed</h5>
                        </div>
                        @elseif($item->sold == 1 && $auction_closed == 1)
                        <div class="text-center sold">
                            <img class="sold" src="/img/sold-stamp.png" alt="item sold">
                        </div>
                        @else
                        <div class="text-center view-item">
                            <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left"
                                data-toggle="tooltip" data-placement="top" title="View Item">
                                View Details
                            </a>
                        </div>

                        @endif
                    </div>
                    <!-- card footer end -->

                </div>
            </div>
            @endforeach
            
        </div>
    </div> <!--  container for item cards  -->
</div>


@endsection