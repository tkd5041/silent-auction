@extends('layouts.auction')

@section('content')

<div class="container" id="events">
    <div class="auction-header">
        <h4><b>{{ $event->name }}</b><br><br>
            <small><b>Starts: </b><span class="text-muted">{{ date('D, M j, Y ', strtotime($bids_start)) }} @
                    {{ date('g:i A', strtotime($bids_start)) }} (MST) </span></small><br>
            <small><b>Ends: </b><span class="text-muted">{{ date('D, M j, Y ', strtotime($bids_end)) }} @
                    {{ date('g:i A', strtotime($bids_end)) }} (MST) </span></small>
        </h4>
    </div>
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
                </div>
    </div>
    <div class="container">
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
                        <p><b>Minimum Bid: </b> <span class="text-muted">${{ $item->initial_bid }}.00</span></p>
                    </div> <!-- div card-body -->
                    <div class="card-footer">
                        <div class="view-description">
                            <blockquote>
                                {{ Str::limit($item->description, 200 ) }}
                            </blockquote>
                        </div>
                        <div class="my-2 float-right view-item">
                            <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                                data-toggle="tooltip" data-placement="top" title="View Item">
                                View Item
                            </a>
                        </div>
                    </div>
                    @else
                    <p>
                        <b>Current Bid: </b><span class="text-muted">${{ $item->current_bid }}.00</span><br>
                        <b>Bidder: </b><span class="text-muted">{{ $item->username }}</span><br>
                        <b>Minimum Bid: </b><span
                            class="text-muted">${{ $item->current_bid + $item->increment }}.00</span>
                    </p>
                </div> <!-- div card-body -->
                <div class="card-footer">
                    <div class="view-description">
                        <blockquote class="description">
                            {{ Str::limit($item->description, 200 ) }}
                        </blockquote>
                    </div>
                    @if(!$item->sold)
                    <div class="my-2 float-right view-item">
                        <a href="/auction/{{$item->id}}/edit" class="btn btn-outline-primary btn-left fa fa-eye"
                            data-toggle="tooltip" data-placement="top" title="View Item">
                            View Item
                        </a>
                    </div>
                    @endif
                    @if($item->sold)
                    <div class="justify-contents-center sold">
                        <img class="sold" src="/img/sold-stamp.png" alt="item sold">
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

</div>


@endsection