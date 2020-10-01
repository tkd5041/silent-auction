@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Manage Images') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4><b>Manage Images For: </b><br>{{ $item->title }}</h4>
                    <hr>
                    <div class="flex-center">
                        <example-component></example-component>
                    </div>
                        <div class="container">
                            <div class="row">
                                @foreach ($images as $image)
                                    <div class="col-2 m-3 p-3 border border-info rounded">
                                    <img class="w-100" src="{{ $image->image }}" alt="">
                                    
                                    <form action="{{ route('admin.image-uploads.destroy', $image) }}" 
                                            method="post"
                                            onsubmit="return confirm('Do you wish to delete this image?')">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $image->id }}">
                                        <input type="hidden" name="image" value="{{ $image->image }}">
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button class="small btn btn-outline-danger mt-2 w-100">Delete</button>
                                    </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection