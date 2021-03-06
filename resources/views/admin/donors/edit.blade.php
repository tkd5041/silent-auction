@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Donor') }}
                    <a href="{{ URL::previous() }}"
                       class="btn btn-outline-primary float-right fa fa-hand-o-left">
                       Back</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.donors.update', $donor) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Donor Name</label>
    
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $donor->name }}" required autofocus>
    
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">Donor Email</label>
    
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $donor->email }}" required autofocus>
    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label text-md-right">Donor Phone</label>
    
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ $donor->phone }}" required autofocus>
    
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    
                        <div>
                            <button class="btn btn-primary" type="submit">
                                Update Donor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection