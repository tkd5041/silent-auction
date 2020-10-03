@extends('layouts.auction')

@section('content')

<div class="container" id="events">
    <div class="auction-header">
        <h2>{{ $event->name }}<br><br>
            <small>Starts: <span class="text-muted">{{ date('D, M j, Y ', strtotime($event->start_date)) }} @ {{ date('g:i A', strtotime($event->start_time)) }} (MST) </span></small><br>
            <small>Starts: <span class="text-muted">{{ date('D, M j, Y ', strtotime($event->end_date)) }} @ {{ date('g:i A', strtotime($event->end_time)) }} (MST) </span></small>
        </h2>
    </div>
    <div class="auction-header float-right">
    <h4 id="bidStatus">Time Before Starts:</h4>
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
                <div class="card" style="width: 16rem;">
                    <div class="card-header">
                        <h5 class="card-title">{{ $item->title}}</h5>
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
                        <p>Minimum Bid: ${{ $item->initial_bid }}.00</p>
                        </div> <!-- div card-body -->
                        <div class="card-footer">
                            <div class="my-2 float-right">
                                <a href="/auction/{{$item->id}}/edit" 
                                    class="btn btn-outline-primary btn-left fa fa-eye" 
                                    data-toggle="tooltip"
                                    data-placement="top" 
                                    title="View Item">
                                    View Item
                                </a>
                            </div>
                        </div>
                        @else
                            <p>
                                <b>Current Bid: $</b>{{ $item->current_bid }}.00<br>
                                <b>Minimum Bid: $</b>{{ $item->current_bid + $item->increment }}.00
                            </p>
                        </div> <!-- div card-body -->
                        <div class="card-footer">
                            <div class="my-2 float-right">
                                <a href="/auction/{{$item->id}}/edit"
                                   class="btn btn-outline-primary btn-left fa fa-eye" 
                                   data-toggle="tooltip"
                                   data-placement="top" 
                                   title="View Item">
                                    View Item
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>


@endsection