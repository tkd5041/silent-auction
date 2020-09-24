@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Items') }}</div>

                <div class="card-body">
                    <div class="container search">
                        <form action="/admin/items/search" method="GET" role="search">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Search Items"
                                    value="{{ $_GET['search_text'] ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                        </form>
                        <div class="input-group-append">
                            <a href="{{ route('admin.items.index') }}"
                                class="btn btn-outline-success">
                                <i class="fa fa-home" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Initial Bid</th>
                                    <th scope="col">Increment</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->initial_bid }}</td>
                                        <td>{{ $item->increment }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @can('edit-users')
                                                    <a href="{{ route('admin.items.edit', $item->id) }}"
                                                        type="button"
                                                        class="btn btn-outline-primary float-left btn-left fa fa-pencil">
                                                    </a>
                                                @endcan
                                                @can('delete-users')
                                                    <form
                                                        action="{{ route('admin.items.destroy', $item) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Do you wish to delete this item?')">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <a
                                                            href="{{ route('admin.items.destroy', $item->id) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger float-left fa fa-trash-o">
                                                            </button>
                                                        </a>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
</tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
