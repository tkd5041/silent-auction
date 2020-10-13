@extends('layouts.pp')

@section('content')
@if ($items->isEmpty())
<div class="container">
    @if(session()->has('message'))
    <div class="row justify-content-center">
        <div class="col-md-8 alert alert-success text-center">
            <h3>{{ session()->get('message') }}</h3>
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <h1 class="text-info">No Winning Items Found</h1>
        <a href="{{ URL::previous() }}"
                       class="btn btn-outline-primary float-right fa fa-hand-o-left">
                       Back</a>
    </div>
</div>
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Items Won</h3>
                    <a href="{{ route('auction', $event->id) }}"
                       class="btn btn-outline-primary float-right fa fa-hand-o-left">
                       Back</a>
                </div>
                <div class="card-body">
                    <div class="container search">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Notes for Winner</th>
                                        <th scope="col">Winning Bid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->notes_for_winner }}</td>
                                        <td class="float-right">${{ $item->current_bid }}.00</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if($paid == 0)
                <div class="card-footer">
                    <h5 class="text-success mr-4 float-right">Total Amount Due: ${{ $total }}.00</h5>
                </div>
                @endif
                @if($paid >= 1)
                <div class="card-footer">
                <span class="text-center sold">
                    <img class="sold" src="/img/paid-stamp.png" alt="item paid">
                </span>
                <h5 class="text-success mr-4 float-right">Total Amount: ${{ $total }}.00</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
<!-- PayPal Button -->
@if ($paid == 0)
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Payment</h3>
                </div>
                <div class="card-body">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection