@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">{{ __('Create Event') }}
                <a href="{{ URL::previous() }}" class="btn btn-outline-primary float-right fa fa-hand-o-left">
                    Back</a>
            </div>

            <div class="card-body">
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ route('admin.events.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Event Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" maxlength="40" placeholder="Limit 40 Characters" required autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start" class="col-md-2 col-form-label text-md-right">Event Start</label>

                        <div class="col-md-6">
                            <input id="start" type="datetime-local"
                                class="form-control @error('start') is-invalid @enderror" name="start" required
                                autofocus>

                            @error('start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end" class="col-md-2 col-form-label text-md-right">Event End</label>

                        <div class="col-md-6">
                            <input id="end" type="datetime-local"
                                class="form-control @error('end') is-invalid @enderror" name="end" required autofocus>

                            @error('end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="submit">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection