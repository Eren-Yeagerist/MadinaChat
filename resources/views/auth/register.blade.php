@extends('layouts.main')
@section('title'){{ 'Register' }}@endsection
@section('content') 
    <div class="card m-auto w-50">
        <div class="card-header">
            <h5 class="card-title">Register</h5>
            @if ($errors->any())
                <div class="alert warning">
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-warning">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('chat.register.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Fullname</label>
                    <input type="text" name="name" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <input type="submit" class="btn btn-primary" value="Register"> | <a href="{{ route('chat.login') }}">login</a>
            </form>
        </div>
    </div>
@endsection