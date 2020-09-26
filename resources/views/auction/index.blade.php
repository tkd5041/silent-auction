@extends('layouts.app')

@section('content')

<div class="container" id="events">
    <div class="auction-header">
        <h1>{{ $event->name }}</h1>
    </div>
    <div class="auction-details">
        <em>Start Date: </em>{{ $event->start_date }} <em>Start Time: </em>{{ $event->start_time }} 
        <em>End Date: </em>{{ $event->end_date }} <em>End Time: </em>{{ $event->end_time }}
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Current Bids</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach($items as $item)
                            <hr>
                            <div>
                                <h4>{{ $item->title }}</h4>
                            </div>
                            <div>Value: {{ $item->value }} </div>
                            @if($item->current_bid == 0)
                                <div>Minimum Bid: ${{ $item->initial_bid }}</div>
                                <a href="/auction/{{$item->id}}/edit"
                                                    type="button"
                                                    class="btn btn-outline-primary float-left btn-left fa fa-gavel"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Enter Bid">
                                                Enter Bid
                                                </a>
                            @else
                                <div>Current Bid: ${{ $item->current_bid }}</div>
                                <div>Minimum Bid: ${{ $item->current_bid + $item->increment }}</div>
                                <a href="/auction/{{$item->id}}/edit"
                                                    type="button"
                                                    class="btn btn-outline-primary float-left btn-left fa fa-gavell"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Enter Bid">
                                                Enter Bid
                                                </a>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($bids as $bid)
                            <hr>
                            <div>
                                <h4>{{ $bid->title }}</h4>
                            </div>
                            <div>{{ $bid->username }} bid ${{ $bid->current_bid }}</div>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>

</div>
@endsection
