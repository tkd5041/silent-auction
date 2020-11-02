@extends('layouts.events')

@section('content')
<div class="container" id="events">
    <div class="border border-success rounded m-3 p-3 w-50 mx-auto my-5">
                <h6 class="text-danger text-center">To get the best view of the items, we suggest you view this on your computer. <br>If
                    you’re on an iPhone, it works best if you make sure you’re updated to iOS 14. Have fun!</h6>
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
                                (Closed)
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