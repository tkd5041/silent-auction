@extends('layouts.events')

@section('content')
<div class="container" id="events">
    <h1>Time Until Next Event:</h1>
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

    <h1>Select An Event To Continue:</h1>
    <div class="row justify-content-center">
        <div class="event-cards">
            <div class="row">
                @foreach($events as $event)
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Event Details
                            @can('manage-users')
                            @if($event->active == 0)
                            <br>
                            <small class="text-warning">
                                (Inactive)
                            </small>
                            @else($event->active == 1)
                            <br>
                            <small class="text-success">
                                (Active)
                            </small>
                            @endif
                            @endcan
                            @if($event->active == 2)
                            <br>
                            <small class="text-danger">
                                (Closed For Bidding)
                            </small>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $event->name }}</h3>
                        <dt>Start Date: </dt>
                        <dd>{{ date('D, M j, Y ', strtotime($event->start)) }} (MST)</dd>
                        <dt>Start Time:</dt>
                        <dd>{{ date('g:i A', strtotime($event->start)) }}</dd>
                        <dt>End Date: </dt>
                        <dd>{{ date('D, M j, Y ', strtotime($event->end)) }} (MST)</dd>
                        <dt>End Time:</dt>
                        <dd>{{ date('g:i A', strtotime($event->end)) }}</dd>
                        <a href="{{  route('auction', $event->id) }}" class="btn btn-primary">Select Event</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection