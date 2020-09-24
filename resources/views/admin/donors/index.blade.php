@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Donors') }}
                    <div class="float-right">
                        <a href="{{ route('admin.donors.create') }}"
                            class="btn btn-outline-primary float-right">
                            <i class="fa fa-plus" aria-hidden="true"> </i> Add donor</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container search">
                        <form action="/admin/donors/search" method="GET" role="search">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Search Donors">
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donors as $donor)
                                    <tr>
                                        <th scope="row">{{ $donor->id }}</th>
                                        <td>{{ $donor->name }}</td>
                                        <td>{{ $donor->email }}</td>
                                        <td>{{ $donor->phone }}</td>
                                        <td>
                                            @can('edit-users')
                                                <a href="{{ route('admin.donors.edit', $donor->id) }}"
                                                    type="button"
                                                    class="btn btn-outline-primary float-left btn-left fa fa-pencil">
                                                </a>
                                            @endcan
                                            @can('delete-users')
                                                <form
                                                    action="{{ route('admin.donors.destroy', $donor) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Do you wish to delete this donor?')">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <a
                                                        href="{{ route('admin.donors.destroy', $donor->id) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger float-left fa fa-trash-o">
                                                        </button>
                                                    </a>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
    
                            </tbody>
                        </table>
                        {{ $donors->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
