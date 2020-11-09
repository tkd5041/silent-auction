@extends('layouts.bid')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-info" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header text-center">
                <h2>{{ $item->title }}</h2>
            </div>
            <div class="card-body">
                <div>
                    <p style="font-size:20px;">{{ $item->description }}</p>
                    @if($images->isEmpty())
                    <div class="text-center">
                        <h4>No Images Available</h4>
                    </div>
                    @else
                    <div>
                        <h6><small class="text-muted">Hover To Enlarge Image</small></h6>
                    </div>
                    <div class="gallery">
                        @foreach($images as $image)
                        <img src="{{ $image->image }} " alt="{{ $item['title'] }}_image_{{ $image->id }}">
                        @endforeach
                    </div>
                    <div>
                        <h6><small class="text-muted">On Mobile Tap Image to Enlarge, Tap Off Image to Close</small>
                        </h6>
                    </div>
                    @endif
                    <div class="my-3">
                        <h4>Value: {{ $item->value }}</h4>
                        <h5><small>(Retail Value: ${{ $item->retail_value }}.00)</small></h5>
                    </div>
                    <div class="bid-group">
                        <hr />
                        <div class="container mb-3">
                            @if ($auction_status == 0)
                            <div>
                                <h4 class="text-muted ml-2">Auction Is: <span class="text-info">PENDING</span></h4>
                                <div class="row pl-3">
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
                                <div class="row pl-3">
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
                                @elseif ($auction_status == 2)
                                <div>
                                    <h4 class="text-muted ml-2">Auction Is: <span class="text-danger">CLOSED</span></h4>
                                    <div class="text-center">
                                        <a href='/pay/{{ $event->id }}/edit' class='btn btn-primary'>Pay Now</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="ml-3" style="max-width: 250px;">
                                <item-bid :item="{{ json_encode($item) }}" />
                            </div>
                            @if($auction_status == 1)
                            <form action="/auction/{{$item->id}}/bid" method="POST"
                                onsubmit="return confirm('All bids are binding. Do you wish to bid this item?')">
                                @csrf
                                {{ method_field('PUT') }}
                                <input type="hidden" name="id" value="{{ $item->id}}">
                                <input type="hidden" name="title" value="{{ $item->title}}">
                                <input type="hidden" name="min_bid" value="{{ $item->current_bid + $item->increment }}">
                                <input type="hidden" name="cur_bid" value="{{ $item->current_bid }}">
                                <div class="input-group pl-3 mb-3 bid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control bid"
                                        aria-label="Amount (to the nearest dollar)" name="bid" id="bid"
                                        value="{{ $item->current_bid == 0 ? $item->initial_bid : $item->current_bid + $item->increment }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="bid ml-3" id="subBtn">
                                    <button class="btn btn-outline-success"><i class="fa fa-gavel" aria-hidden="true">
                                        </i>
                                        Submit Bid
                                    </button>
                                </div>
                                </span>
                            </form>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bid">
                    <button class="btn btn-outline-primary ml-3" type="button"
                        onclick="location.href='/auction/{{session('selected_event')}}/'">Cancel and Go Back</button>



                </div>
            </div>
        </div>

        @endsection