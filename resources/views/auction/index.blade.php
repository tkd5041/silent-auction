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
        @if($auction_closed == 0)
        <div class="border border-success rounded pl-2 pt-1 my-1 bid-tips">
            <h5 class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i><small> Page refreshes every 60
                    seconds.</small></h5>
            <h5><small>TIP: Hit <code><i class="fa fa-refresh" aria-hidden="true"></i></code> Refresh for quicker page
                    response.</small></h5>
        </div>
        @endif
    </div> <!--  auction-header 1  -->
    <div class="auction-header float-right">
        <div>
        @if($auction_closed == 0)
            <h3 class="text-danger">Bidding Ends:</h3>
            <h4 class="text-muted ml-2">8:00 PM Eastern Time</h4>
            <h4 class="text-muted ml-2">5:00 PM Mountain Standard</h4>
        @endif
        <h4 class="text-muted ml-2">Auction Is: <span
                class="{{ ($auction_closed == 0 ) ? 'text-success' : 'text-danger' }}">{{ ($auction_closed == 0 ) ? 'OPEN' : 'CLOSED' }}</span>
        </h4>
        @if($auction_closed)
        <div class="text-center">
        <a href='/pay/{{ $event->id }}/edit' class='btn btn-primary'>Pay Now</a>
        </div>
        @endif
        </div>
    </div> <!--  auction-header timer and pay button  -->
    <div class="container">
        <!--  container for item cards  -->
        <div class="row  row-cols-sm-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">

            @foreach($items as $item)
            <div class="col mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ Str::limit($item->title, 40) }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Retail Value: ${{ $item->retail_value }}.00)</h6>


                    </div>
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
                        <p><b>Minimum Bid: </b> <span class="text-danger">${{ $item->initial_bid }}.00</span></p>
                    </div> <!-- div card-body -->
                    <div class="card-footer">
                        @if($auction_closed == 1)
                        <div class="view-description">
                            <blockquote>
                                {{ Str::limit($item->description, 200 ) }}
                            </blockquote>
                        </div>
                        @endif
                        @if( $auction_closed == 0)
                        <div class="text-center view-item">
                            <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                                data-toggle="tooltip" data-placement="top" title="View Item">
                                View Item
                            </a>
                        </div>
                        @endif
                        @if(($item->sold == 0 || $item->sold == 2) && $auction_closed == 1)
                        <div class="text-center sold">
                            <h5 class="text-info">Item Closed</h5>
                        </div>
                        @endif
                    </div>
                    @else
                    <p>
                        <b>Bidder: </b><span class="text-muted ml-1"><mark> {{ $item->username }} <mark></span><br>
                        <b>Current Bid: </b><span class="text-success ml-2">${{ $item->current_bid }}.00</span><br>
                        <b>Minimum Bid: </b><span
                            class="text-danger">${{ $item->current_bid + $item->increment }}.00</span>
                    </p>
                </div> <!-- div card-body -->
                <div class="card-footer">
                    @if($auction_closed == 1)
                    <div class="view-description">
                        <blockquote class="description">
                            {{ Str::limit($item->description, 200 ) }}
                        </blockquote>
                    </div>
                    @endif
                    @if( $auction_closed == 0)
                    <div class="text-center view-item">
                        <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                            data-toggle="tooltip" data-placement="top" title="View Item">
                            View Item
                        </a>
                    </div>
                    @endif
                    @if($item->sold == 0 && $auction_closed == 1)
                    <div class="text-center sold">
                        <h5 class="text-info">Item Closed</h5>
                    </div>
                    @endif
                    @if($item->sold == 2 && $auction_closed == 1)
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
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div> <!--  container for item cards  -->
</div>


@endsection