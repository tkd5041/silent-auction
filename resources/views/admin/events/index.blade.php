@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Events') }}
                    <div class="float-right">
                        <a href="{{ route('admin.events.create') }}" class="btn btn-outline-primary float-right">
                            <i class="fa fa-plus" aria-hidden="true"> </i> Add Event</a>
                    </div>  
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">#</th>
                                <th scope="col" style="text-align: center">Name</th>
                                <th scope="col" style="text-align: center">Start Date</th>
                                <th scope="col" style="text-align: center">Start Time</th>
                                <th scope="col" style="text-align: center">End Date</th>
                                <th scope="col" style="text-align: center">End Time</th>
                                <th scope="col" style="text-align: center">Active</th>
                                <th scope="col" style="text-align: center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ $event->id }}</th>
                                    <td style="text-align: center">{{ $event->name }}</td>
                                    <td style="text-align: center">{{ $event->start_date }}</td>
                                    <td style="text-align: center">{{ $event->start_time }}</td>
                                    <td style="text-align: center">{{ $event->end_date }}</td>
                                    <td style="text-align: center">{{ $event->end_time }}</td>
                                    <td style="text-align: center">
                                        <div style="text-align: center; color: @if ($event->active ===1) green @else red @endif;">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                    </td>
                                    <td>
                                        @can('edit-users')
                                            <a
                                                href="{{ route('admin.events.edit', $event->id) }}"
                                                type="button"
                                                class="btn btn-outline-primary float-left btn-left fa fa-pencil">
                                            </a>
                                        @endcan
                                        @can('delete-users')
                                            <form
                                                action="{{ route('admin.events.destroy', $event) }}"
                                                method="POST"
                                                onsubmit="return confirm('Do you wish to delete this event?')">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <a
                                                    href="{{ route('admin.events.destroy', $event->id) }}">
                                                    <button type="submit"
                                                        class="btn btn-outline-danger float-left fa fa-trash-o">
                                                    </button>
                                                </a>
                                            </form>
                                        @endcan
                                    </td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection