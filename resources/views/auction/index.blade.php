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
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
            @foreach($items as $item)
            <div class="col mb-4">
                <div class="card">
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
                            alt="{{ $item->title}} image {{ $item->id }}">
                        @endif
                        <hr>
                        @if($item->current_bid == 0)
                        <p>Minimum Bid: ${{ $item->initial_bid }}.00</p>
                        </div> <!-- div card-body -->
                        <div class="card-footer">
                            <div class="my-2 float-right">
                                <a href="/auction/{{$item->id}}/edit" type="button"
                                    class="btn btn-outline-primary btn-left fa fa-eye" data-toggle="tooltip"
                                    data-placement="top" title="View Item">
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
                                <a href="/auction/{{$item->id}}/edit" type="button"
                                    class="btn btn-outline-primary btn-left fa fa-eye" data-toggle="tooltip"
                                    data-placement="top" title="View Item">
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