@extends('layouts.main')
@section('title'){{ 'Notification' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>Notification <i class="fa-regular fa-bell"></i></h3>
        </div>
        <div class="p-2">
            <a type="button" class="btn btn-secondary active position-relative">
                Refresh
                <span><i class="fa-solid fa-arrows-rotate"></i></span>
            </a>
        </div>
    </div>

    @if ($notifications->count() == 0)
        <div class="alert alert-warning fade show" role="alert">
            <strong>Warning!</strong> You don't have any notification.
        </div>
    @else 
        @foreach ($notifications as $notification)    
            <a href="{{ $notification->url }}" class="text-decoration-none text-dark">
                <div class="card border-warning rounded-0 mb-2">
                    <div class="card-body">
                        <b>{{ $notification->senderUser->name }}</b> | <small>{{ $notification->created_at }}</small>
                        <p class="card-text">{!! $notification->message !!}</p>
                    </div>
                </div>
            </a>
        @endforeach
    @endif

@endsection
