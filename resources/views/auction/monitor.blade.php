@extends('layouts.monitor')

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
                        <td style="text-align: center">{{ $item->username }}</td>
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