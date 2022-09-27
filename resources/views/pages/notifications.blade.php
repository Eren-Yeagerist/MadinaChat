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

    <a href="" class="text-decoration-none text-dark">
        <div class="card border-warning rounded-0 mb-2">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div>
    </a>

    <a href="" class="text-decoration-none text-dark">
        <div class="card border rounded-0 mb-2">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div>
    </a>

    <a href="" class="text-decoration-none text-dark">
        <div class="notif card card border rounded-0 mb-2">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div>
    </a>
@endsection
