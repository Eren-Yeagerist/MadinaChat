@extends('layouts.main')
@section('title'){{ 'Create Chat' }}@endsection
@section('content')
    <div class="card m-auto w-50">
        <div class="card-header">
            <h5 class="card-title">Create Session</h5>
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