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
        <div class="border border-success rounded pl-2 pt-1 my-1 bid-tips" >
            <h5 class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i><small> Page refreshes every 60
                    seconds.</small></h5>
            <h5><small>TIP: Hit <code><i class="fa fa-refresh" aria-hidden="true"></i></code> Refresh for quicker page
                    response.</small></h5>
        </div>
    </div> <!--  auction-header 1  -->
    <div class="auction-header float-right">
        <b>
            <h4 id="bidStatus">Time Before Starts:</h4><b>
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
                    <div class="border border-secondary rounded px-2 pt-2 mt-2 bid-tips">
                        <h5 class="text-primary"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <small>Bids made in the last 20 seconds extend time for that item.</small>
                    </div>
                </div>
    </div> <!--  auction-header timer and pay button  -->
    <div class="container">
        <!--  container for item cards  -->
        <div class="row  row-cols-sm-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
            <div class="col mb-4 bid-tips">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="card-title">Latest Bids</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Last 5 Bids</h6>
                    </div>
                    <div class="card-body">
                        @foreach($bids as $bid)
                        <h6>{{ $bid->title }}</h6>
                        <h6 class="text-muted ml-2">by <mark> {{ $bid->username }} </mark></h6>
                        <p class="text-muted ml-2">for <span class="text-success">${{ $bid->current_bid }}.00</span>
                            <i class="fa fa-at" aria-hidden="true"></i>
                            <cite>{{ date('g:i A', strtotime($bid->created_at) - 25200 ) }}</cite>
                        </p>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            @foreach($items as $item)
            <div class="col mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ Str::limit($item->title, 40) }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Retail Value: ${{ $item->retail_value }}.00)</h6>
                        <p class="text-muted"><small> End: {{date('g:i:h', strtotime($item->end_time))}}</small></p>

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
                        <div class="view-description">
                            <blockquote>
                                {{ Str::limit($item->description, 200 ) }}
                            </blockquote>
                        </div>

                        <div class="text-center view-item">
                            <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                                data-toggle="tooltip" data-placement="top" title="View Item">
                                View Item
                            </a>
                        </div>

                        @if(($item->sold == 0 || $item->sold == 2) && $dt_now >= $dt_sp)
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
                    <div class="view-description">
                        <blockquote class="description">
                            {{ Str::limit($item->description, 200 ) }}
                        </blockquote>
                    </div>

                    @if($item->sold == 0 && $dt_now < $dt_sp) <div class="text-center view-item">
                        <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                            data-toggle="tooltip" data-placement="top" title="View Item">
                            View Item
                        </a>
                </div>
                @endif
                @if($item->sold == 0 && ($dt_now +1) > $dt_sp)
                <div class="text-center sold">
                    <h5 class="text-info">Item Closed</h5>
                </div>
                @endif
                @if($item->sold == 2 && ($dt_now +1) > $dt_sp)
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