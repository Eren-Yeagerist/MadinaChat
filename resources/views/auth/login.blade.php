@extends('layouts.main')
@section('title'){{ 'Login' }}@endsection
@section('content') 
    <div class="card m-auto w-50">
        <div class="card-header">
            <h5 class="card-title">Login</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('chat.validate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">username</label>
                    <input type="text" name="username" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <input type="submit" class="btn btn-primary" value="Login">
            </form>
        </div>
    </div>
@endsection