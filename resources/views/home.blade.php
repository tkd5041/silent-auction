@extends('layouts.events')

@section('content')
<div class="container" id="events">
    @if ($events->isEmpty())
    <h4 class="text-center text-info">No Active Events Available To View</h4>
    @else
    <h4 class="text-center text-muted">Select An Event To Continue:</h4>
    @endif
    <div class="row justify-content-center">
        <div class="event-cards">
            <div class="row">
                @if (!empty($events))
                <div class="card-deck">
                    @foreach($events as $event)
                    <div class="card bg-light" style="max-width: 16rem; min-width: 14rem;">
                        <div class="card-header pt-3 pb-2">
                            <h3 class="card-title mb-0">{{ $event->name }}</h3>
                            @can('manage-users')
                            @if($event->active == 0)
                            <small class="text-warning">INACTIVE</small>
                            @elseif($event->active == 1)
                            <small class="text-success">ACTIVE</small>
                            @endif
                            @endcan
                        </div>
                        <div class="card-body p-2">
                            <dt>Start Date: </dt>
                            <dd>{{ date('D, M j, Y ', strtotime($event->start)) }} (MST)</dd>
                            <dt>Start Time:</dt>
                            <dd>{{ date('g:i A', strtotime($event->start)) }}</dd>
                            <dt>End Date: </dt>
                            <dd>{{ date('D, M j, Y ', strtotime($event->end)) }}</dd>
                            <dt>End Time:</dt>
                            <dd>{{ date('g:i A', strtotime($event->end)) }} (MST)</dd>
                        </div>
                        <div class="card-footer">
                            @can('manage-users')
                            @if($event->id != 2)
                            <a href="{{  route('auction', $event->id) }}" class="btn btn-secondary">Select Event</a>
                            @endif
                            @endcan
                            @if($event->id == 2)
                            <a href="{{  route('auction', $event->id) }}" class="btn btn-secondary">Select Event</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    
    @if ($closed->isEmpty())
    <h4 class="text-center mt-5">No Closed Events Available To View</h4>
    @else
    <h4 class="text-center mt-5 mb-3">Closed Events Available To View</h4>
    <div class="row justify-content-center">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Event</th>
                    <th scope="col">End Date</th>
                    <th scope="col"> <span class="float-right">Action</span></th>
                </tr>
            </thead>
            <tbody>
            @foreach($closed as $clsd)
                <tr>
                    <th scope="row">{{ $clsd->id }}</th>
                    <td>{{ $clsd->name }}</td>
                    <td>{{ date('D, M j, Y ', strtotime($clsd->end)) }}</td>
                    <td><!--a href="{{  route('auction', $clsd->id) }}" class="btn btn-sm btn-outline-info float-right">View Event</a></td-->
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @endif


</div>
@endsection