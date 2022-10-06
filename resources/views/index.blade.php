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
    @elseif (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form class="row mb-3" action="/">
        <div class="col">
            <label class="visually-hidden" for="inline-form-name">Name</label>
            <input type="text" name="keyword" class="form-control" id="keyword" placeholder="keyword" value="{{ request('keyword') }}">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            <a href="{{ route('chat.home') }}" class="btn btn-secondary active position-relative">
                <span><i class="fa-solid fa-sync"></i></span>
            </a>
        </div>
        <div class="col">
        </div>
    </form>

    @if ($chats->count() == 0)
        <div class="alert alert-warning fade show" role="alert">
            <strong>Warning!</strong> You don't have any chat.
        </div>
    @else
        @foreach ($chats as $chat)    
            <a href="{{ route('chat.chat', $chat) }}" class="text-decoration-none text-dark">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $chat->user->name }}
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>{{ $chat->title }}</p>
                            <footer class="blockquote-footer">
                                {{ $chat->created_at }} | <span class="badge {{ $chat->status()["color"] }}">{{ $chat->status()["status"] }}</span>
                                @if ($chat->status_rating == 0 && $chat->status()["status"] == 'finished')
                                    
                                    @if (auth()->user()->role() == 'user')
                                        <a href="{{ route('user.chat.rate', $chat->slug) }}">
                                            <span class="badge text-bg-warning">give rating</span>
                                        </a>
                                    @else
                                        <span class="badge text-bg-warning">not rated</span>
                                    @endif
                                @endif  
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </a>
        @endforeach
    @endif

@endsection