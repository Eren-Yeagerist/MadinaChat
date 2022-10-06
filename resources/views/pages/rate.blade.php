@extends('layouts.main')
@section('title'){{ 'Rating' }}@endsection
@section('content')
    <div class="card m-auto w-50">
        <div class="card-header">
            <h5 class="card-title">Give rating to [Chat Session] session</h5>
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
            <form action="{{ route('user.chat.rate.store', $chat->id) }}" method="post">
                @csrf
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                </div>
                <br><br><br><input type="submit" class="btn btn-primary" name="" value="submit">
            </form>
        </div>
    </div>
@endsection