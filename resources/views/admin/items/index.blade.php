@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Items') }}
                    <div class="float-right">
                        <a href="{{ route('admin.items.create') }}"
                            class="btn btn-outline-primary float-right">
                            <i class="fa fa-plus" aria-hidden="true"> </i> Add Item</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container search">
                        <form action="/admin/items/search" method="GET" role="search">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Search Items">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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
                                            @can('edit-users')
                                                <a href="{{ route('admin.items.edit', $item->id) }}"
                                                    type="button"
                                                    class="btn btn-outline-primary float-left btn-left fa fa-pencil"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Edit Item">
                                                </a>
                                            @endcan
                                            @can('edit-users')
                                                <a href="{{ route('admin.image-uploads.index', $item->id) }}"
                                                    type="button"
                                                    class="btn btn-outline-success float-left btn-left fa fa-picture-o"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Manage Images">
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
                                                            class="btn btn-outline-danger float-left fa fa-trash-o"
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="Delete Item">
                                                        </button>
                                                    </a>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
    
                            </tbody>
                        </table>
                        {{ $items->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
