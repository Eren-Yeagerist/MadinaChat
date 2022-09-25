@extends('layouts.main')
@section('title'){{ 'Notification' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>| Chat title | <i class="fa-solid fa-comment"></i></h3>
        </div>
        <div class="p-2">
            <button type="button" class="btn btn-secondary active position-relative">
                Refresh
                <span><i class="fa-solid fa-arrows-rotate"></i></span>
            </button>
        </div>
    </div>

    <div class="chat bg-primary">
        <div class="card border-success rounded-0 mb-2">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.<br><a href=""
                        class="text-decoration-none badge bg-danger">delete</a></p>
            </div>
        </div>
        
        <div class="card border-primary rounded-0 mb-2">
            <div class="card-body">
                <b>Admin</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div>
        
        <div class="card border-danger rounded-0 mb-2 ">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small> | <span><i class="fa-solid fa-ban"></i></span>
                <p class="card-text">----------------- Pesan telah dihapus -----------------</p>
            </div>
        </div>
        
        <div class="card border-danger rounded-0 mb-2 ">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small> | <span><i class="fa-solid fa-ban"></i></span>
                <p class="card-text">----------------- Pesan telah dihapus -----------------</p>
            </div>
        </div>

        <div class="card border-primary rounded-0 mb-2">
            <div class="card-body">
                <b>Admin</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div>
        
        <div class="card border-danger rounded-0 mb-2 ">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small> | <span><i class="fa-solid fa-ban"></i></span>
                <p class="card-text">----------------- Pesan telah dihapus -----------------</p>
            </div>
        </div>
        
        <div class="card border-danger rounded-0 mb-2 ">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small> | <span><i class="fa-solid fa-ban"></i></span>
                <p class="card-text">----------------- Pesan telah dihapus -----------------</p>
            </div>
        </div>

        <div class="card border-danger rounded-0 mb-2 ">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small> | <span><i class="fa-solid fa-ban"></i></span>
                <p class="card-text">----------------- Pesan telah dihapus -----------------</p>
            </div>
        </div>
    </div>

    <div class="col-md-auto position-absolute bottom-0 w-50">
        <div class="d-flex justify-content-center">
            <div class="w-100">
                <textarea name="" id="" class="form-control mb-2" cols="30" rows="5"></textarea>
                <button class="btn btn-primary btn-lg">Send</button>
            </div>
        </div>
    </div>
@endsection