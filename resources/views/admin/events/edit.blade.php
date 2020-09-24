@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Event') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.events.update', $event) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Event Name</label>
    
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{$event->name}}" required autofocus>
    
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="start_date" class="col-md-2 col-form-label text-md-right">Event Start Date</label>
    
                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror"
                            name="start_date" value="{{ $event->start_date }}" required autofocus>
    
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="start_time" class="col-md-2 col-form-label text-md-right">Start Time</label>
    
                            <div class="col-md-6">
                                <input id="start_time" type="time" class="form-control @error('start_time') is-invalid @enderror"
                            name="start_time" value="{{ $event->start_time }}" required  autofocus>
    
                                @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-2 col-form-label text-md-right">Event End Date</label>
    
                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror"
                            name="end_date" value="{{ $event->end_date }}" required autofocus>
    
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="end_time" class="col-md-2 col-form-label text-md-right">End Time</label>
    
                            <div class="col-md-6">
                                <input id="end_time" type="time" class="form-control @error('end_Time') is-invalid @enderror"
                            name="end_time" value="{{ $event->end_time }}"  required  autofocus>
    
                                @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="active" class="col-md-2 col-form-label text-md-right">Active</label>

                            <div class="form-check">
                                <input type="checkbox" name="active" id="active" value="{{ $event->id }}"
                                @if($event->active === 1) checked @endif>
                            </div>
                        </div>
    
                        <div>
                            <button class="btn btn-primary" type="submit">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection