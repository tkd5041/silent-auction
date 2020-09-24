@extends('layouts.app')

@section('content')
<div class="container" id="events">
    <h1>Select An Event To Continue</h1>
    <div class="row justify-content-center">
        <div class="event-cards">
            <div class="row">
                @foreach($events as $event)
                    <div class="card bg-light">
                        <div class="card-header"><h5>Event Details</h5></div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $event->name }}</h3>
                            <dt>Start Date:</dt><dd>{{ date('D, M j, Y ', strtotime($event->start_date)) }}</dd>
                            <dt>Start Time:</dt><dd>{{ date('g:i A', strtotime($event->start_time)) }}</dd>
                            <dt>End Date:</dt><dd>{{ date('D, M j, Y ', strtotime($event->end_date)) }}</dd>
                            <dt>End Time:</dt><dd>{{ date('g:i A', strtotime($event->end_time)) }}</dd>
                        <a href="{{  route('auction', $event->id) }}" class="btn btn-primary">Select Event</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
