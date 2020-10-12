@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header text-center">
                <h3>Send SMS Message</h3>
            </div>
            <div class="card-body">
                <form action='' method='post'>
                    @csrf
                    @if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                        <li class="text-danger"> {{ $error }} </li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="form-group">
                        <label for="numbers">Phone numbers (seperated with a comma [,])</label>
                        <input type='text' class="form-control" name='numbers' />
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" rows="3" name='message'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="numbers">PIN</label>
                        <input type='number' class="form-control w-25" name='pin' />
                    </div>
                    <button class="btn btn-primary" type='submit'>Send!</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection