@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Manage Images') }}</div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-info" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <h4><b>Manage Images For:</b></h4>
                <h5>{{ $item->title }}</h5>
                <hr>
                <div class="flex-center">
                    <div class="container" style="width:100%;">
                        <div class="row justify-content-center">
                            <form action="{{ route('image.add', $item) }}" method="POST" accept-charset="UTF-8"
                                enctype="multipart/form-data" class="m-8" id="image-upload">
                                @csrf
                                <div class="text-center">
                                    <h4 class="text-info">Image Types (jpeg/jpg/png/gif) | 4096KB Max</h4>
                                </div>
                                <div class="form-group text-center">
                                    <label for="image text-primary">Select Image</label>
                                    <input id="image" type="file" name="image">
                                </div>
                                <button type="submit" class="btn btn-dark d-block w-50 mx-auto">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="row">
                        @foreach ($images as $image)
                        <div class="col-2 m-3 p-3 border border-info rounded">

                            <a class="btn btn-sm mb-2 
                                {{ ($image->main == 1) ? 'btn-primary' : 'btn-outline-secondary' }}" @if ($image->main
                                == 1)
                                href="#"
                                @else
                                href="/admin/image-uploads/{{$image->id}}/mp"
                                @endif
                                style="min-width: 80px;">
                                <small>
                                    {{ ($image->main == 1) ? 'Primary' : 'Make Primary' }}
                                </small>
                            </a>
                            <form action="{{ route('admin.image-uploads.destroy', $image) }}" method="post"
                                onsubmit="return confirm('Do you wish to delete this image?')">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="id" value="{{ $image->id }}">
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button class="small btn btn-sm btn-outline-danger mb-2 w-100">Delete</button>
                            </form>
                            <hr>
                            <img class="w-100" src="{{ $image->image }}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-primary float-right fa fa-hand-o-left"
                    href="{{ route('admin.items.index') }}"> Go
                    Back</a>
            </div>
        </div>
    </div>
</div>
@endsection