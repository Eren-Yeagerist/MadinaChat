@extends('layouts.main')
@section('title'){{ 'Aplikasi Chat' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>Chat List <i class="fa-regular fa-message"></i></h3>
        </div>
        <div class="p-2">
            
            @if (auth()->user()->role() == 'user')
                <a href="{{ route('user.chat.create') }}" type="button" class="btn btn-secondary active position-relative">
                    Mulai Chat
                    <span><i class="fa-solid fa-plus"></i></span>
                </a>
            @endif
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
    @endif

    @foreach ($chats as $item)    
        <a href="{{ route('user.chat.chat', $item) }}" class="text-decoration-none text-dark">
            <div class="card mb-3">
                <div class="card-header">
                    {{ $item->user->name }}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $item->title }}</p>
                        <footer class="blockquote-footer">
                            {{ $item->created_at }} | <span class="badge {{ $item->status()["color"] }}">{{ $item->status()["status"] }}</span>
                             @if ($item->status_rating == 0)
                                <span class="badge text-bg-warning">not rated</span>
                             @endif  
                        </footer>
                    </blockquote>
                </div>
            </div>
        </a>
    @endforeach

@endsection