@extends('layouts.main')
@section('title'){{ 'Aplikasi Chat' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>Chat List <i class="fa-regular fa-message"></i></h3>
        </div>
        <div class="p-2">
            <button type="button" class="btn btn-secondary active position-relative">
                Mulai Chat
                <span><i class="fa-solid fa-plus"></i></span>
            </button>
        </div>
    </div>
    
    <a href="" class="text-decoration-none text-dark">
        <div class="card mb-3">
            <div class="card-header">
                Anda
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>A well-known quote, contained in a blockquote element.</p>
                    <footer class="blockquote-footer">2022-09-23 06:23:53 | <span class="badge text-bg-warning">Belum ditanggapi</span></footer>
                </blockquote>
            </div>
        </div>
    </a>

    <a href="" class="text-decoration-none text-dark">
        <div class="card mb-3">
            <div class="card-header">
                Anda
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>A well-known quote, contained in a blockquote element.</p>
                    <footer class="blockquote-footer">2022-09-23 06:23:53 | <span class="badge text-bg-success">sedang berjalan</span>
                    </footer>
                </blockquote>
            </div>
        </div>
    </a>

    <a href="" class="text-decoration-none text-dark">
        <div class="card mb-3">
            <div class="card-header">
                Anda
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>A well-known quote, contained in a blockquote element.</p>
                    <footer class="blockquote-footer">2022-09-23 06:23:53 | <span class="badge text-bg-primary">selesai</span></footer>
                </blockquote>
            </div>
        </div>
    </a>
@endsection