@extends('layouts.monitor')

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
        @if($auction_closed == 1)
        <div>
            <h4 class="text-muted ml-2">Auction Is: <span class="text-danger">CLOSED</span></h4>
        </div>
        @elseif ($auction_closed == 0)
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
        @elseif ($auction_closed == 2)
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
        @endif
        <hr class="wd-50">
        <h5 class="float-right">Persons Online: <span class="badge badge-pill badge-warning mt-0">@{{ numberOfUsers }}
        </h5>
    </div> <!--  auction-header 1  -->
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">#</th>
                        <th scope="col">Title</th>
                        <th class="text-center" scope="col">Value</th>
                        <th class="text-center" scope="col">Sold</th>
                        <th class="text-center" scope="col">Bidder</th>
                        <th class="text-center" scope="col">Bid</th>
                        <th class="text-center" scope="col">Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <th scope="row" style="text-align: center">{{ $item->id }}</th>
                        <td style="text-align: left">{{ $item->title }}</td>
                        <td style="text-align: center">${{ $item->retail_value }}.00</td>
                        <td style="text-align: center">{{ ($item->sold == 1) ? 'Yes' : 'No' }}</td>
                        <td style="text-align: center">{{ $item->username }} | {{$item->name}}</td>
                        <td style="text-align: right">${{ $item->current_bid }}.00</td>
                        <td style="text-align: center">{{ ($item->paid) ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection