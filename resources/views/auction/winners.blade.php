@extends('layouts.winners')

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
    
    <div class="container">
        <div class="table-responsive">
            <table id="winners" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Item ID</th>
                        <th class="th-sm">Title</th>
                        <th class="th-sm">Winner</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Phone</th>
                        <th class="th-sm">Bid</th>
                        <th class="th-sm">Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->name }} ({{$item->username}})</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td class="text-right text-primary">${{ $item->current_bid }}.00</td>
                        <td class="text-center {{ $item->paid ? 'text-success' : 'text-danger' }}">{{ $item->paid ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection