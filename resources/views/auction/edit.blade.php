@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header text-center">
                <h2>{{ $item->title }}</h2>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div>
                    <blockquote>{{ $item->description }} - Retail Value: {{ $item->retail_value }}</blockquote>
                    <hr>
                    <div class="gallery">
                        @foreach($images as $image)
                            <img src="{{ $image->image }} " alt="" class="gallery">
                        @endforeach
                    </div>
                    <hr>
                    <div>
                        <h5>Current Bid:</h5> {{ $item->current_bid }}
                    </div>
                    <div>
                        <h5>Minimum Bid:</h5> {{ $item->current_bid + $item->increment }}
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div>
                    <a href="{{ URL::previous() }}" class="btn btn-outline-warning"> <i
                            class="fa fa-chevron-circle-left"></i> Cancel and Go Back</a>
                </div>
                <form action="/auction/{id}/bid" method="POST">
                    @csrf
                    <div>
                    </div>
                    <div class="float-right">
                        <input type="number" name="bid" id="bid">
                    </div>
                    <div class="float-right">
                        <button class="btn btn-outline-success"><i class="fa fa-gavel" aria-hidden="true"> </i>
                        SubmitBid
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
