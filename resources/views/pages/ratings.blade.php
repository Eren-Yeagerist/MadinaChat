@extends('layouts.main')
@section('title'){{ 'Notification' }}@endsection
@section('content')
    <h3 class="mb-4">Chat Rating <i class="fa-regular fa-star"></i></h3>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach ($ratings as $item)    
        <a href="" class="text-decoration-none text-dark">
            <div class="card mb-3">
                <div class="card-header">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $item->rating)
                            <span class="fa fa-star checked"></span>
                        @else
                            <span class="fa fa-star"></span>
                        @endif
                    @endfor
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>{{ $item->chatSession->title }}</p>
                        <footer class="blockquote-footer"> {{ $item->chatSession->created_at }} <i class="fa-solid fa-arrow-right"></i> {{ $item->chatSession->updated_at }} </footer>
                    </blockquote>
                </div>
            </div>
        </a>
    @endforeach

@endsection