@extends('layouts.main')
@section('title'){{ 'Create Chat' }}@endsection
@section('content')
    <div class="card m-auto w-50">
        <div class="card-header">
            <h5 class="card-title">Create Session</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.chat.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">title</label>
                    <input type="text" name="title" class="form-control" id="title">
                </div>
                <input type="submit" class="btn btn-success" value="Create">
            </form>
        </div>
    </div>
@endsection