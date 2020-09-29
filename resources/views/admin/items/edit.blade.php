@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">{{ __('Edit Item') }}</div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('admin.items.update', $item) }}" method="POST">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="form-group row">
                        <label for="donor" class="col-md-2 col-form-label text-md-right">Select Donor</label>

                        <div class="col-md-8">
                            <select id="donor" class="form-control @error('donor') is-invalid @enderror"
                                name="donor" required autofocus>
                                <option value="">Select Donor</option>
                                @foreach($donors as $donor)
                                    <option value="{{ $donor->id }}" @if($item->donor_id == $donor->id) selected @endif>{{ $donor->name }}</option>
                                @endforeach
                            </select>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label text-md-right">Item Title</label>

                        <div class="col-md-8">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                name="title" value="{{$item->title}}"   required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description " class="col-md-2 col-form-label text-md-right">Item Description
                        </label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="description" id="description" cols="40" rows="5"
                                @error('title') is-invalid @enderror>{{$item->description}}</textarea>

                            @error('description ')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="value" class="col-md-2 col-form-label text-md-right">Item Value</label>

                        <div class="col-md-8">
                            <input id="value" type="text" class="form-control @error('value') is-invalid @enderror"
                                name="value" value="{{$item->value}}" required autofocus>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="retail_value" class="col-md-2 col-form-label text-md-right">Item Retail Value</label>

                        <div class="col-md-8">
                            <input id="retail_value" type="number" class="form-control @error('retail_value') is-invalid @enderror"
                                name="retail_value" value="{{$item->retail_value}}" required  autofocus>

                            @error('retail_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inital_bid" class="col-md-2 col-form-label text-md-right">Initial Bid
                            Value</label>

                        <div class="col-md-8">
                            <input id="initial_bid" type="number" value="{{$item->initial_bid}}"
                                class="form-control @error('initial_bid') is-invalid @enderror" name="initial_bid"
                                required autofocus>

                            @error('initial_bid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="increment" class="col-md-2 col-form-label text-md-right">Increment Value</label>

                        <div class="col-md-8">
                            <input id="increment" type="number"  value="{{$item->increment}}"
                                class="form-control @error('increment') is-invalid @enderror" name="increment"
                                required autofocus>

                            @error('increment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="notes_for_winner" class="col-md-2 col-form-label text-md-right">Notes For Winner</label>
    
                            <div class="col-md-8">
                                <input id="notes_for_winner" type="text" class="form-control @error('notes_for_winner') is-invalid @enderror"
                                    name="notes_for_winner" value="{{$item->notes_for_winner}}"  autofocus>
    
                                @error('notes_for_winner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    <div>
                        <button class="btn btn-primary" type="submit">
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
