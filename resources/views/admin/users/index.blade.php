@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    <div class="container search">
                        <form action="/admin/users/search" method="GET" role="search">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Search Users">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @can('edit-users')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                type="button"
                                                class="btn btn-outline-primary float-left btn-left fa fa-pencil">
                                            </a>
                                        @endcan
                                        @can('delete-users')
                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Do you wish to delete this user?')">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <a
                                                    href="{{ route('admin.users.destroy', $user->id) }}">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
