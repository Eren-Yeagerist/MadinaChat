@extends('layouts.main')
@section('title'){{ 'Chat' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>| {{ $chat->title }} | <i class="fa-solid fa-comment"></i></h3>
        </div>
        <div class="p-2">
            <button type="button" class="btn btn-secondary active position-relative">
                Refresh
                <span><i class="fa-solid fa-arrows-rotate"></i></span>
            </button>
        </div>
    </div>

    <div class="chat border p-3">
        <div class="card border-success rounded-0 mb-2">
            <div class="card-body">
                <b>Andi Manaf</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.<br><a href=""
                        class="text-decoration-none badge bg-danger">delete</a></p>
            </div>
        </div>
        
        {{-- <div class="card border-primary rounded-0 mb-2">
            <div class="card-body">
                <b>Admin</b> | <small>2022-09-23</small>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
            </div>
        </div> --}}
        
    </div>

    <div class="col-md-auto position-absolute bottom-0 w-50 mb-4">
        <div class="d-flex justify-content-center">
            <div class="w-100">
                @csrf
                <input type="hidden" name="session_id" value="{{ $chat->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <textarea name="msg" id="msg" class="form-control mb-2" cols="30" rows="5" required></textarea>
                <div id="validation" class="invalid-feedback">
                    Please enter a message.
                </div>
                {{-- <input type="submit" name="" id=""> --}}
                <button class="btn btn-primary btn-lg" id="send_msg">Send</button>
            </div>
        </div>
    </div>
    
    <script>
        $(function() {
            const Http = window.axios;
            const Echo = window.Echo;
            const name = "{{ Auth::user()->name }}";
            const user_id = "{{ Auth::user()->id }}";
            const chat_id = "{{ $chat->id }}";
            const msg = $('#msg');

            $('#msg').on('keyup', function() {
                $(this).removeClass('is-invalid');
            });

            $('#send_msg').click(function() {
                if (msg.val() == '') {
                    msg.addClass('is-invalid');
                } else {
                    Http.post("{{ route('chat.send') }}", {
                        'user_id': user_id,
                        'session_id': chat_id,
                        'message' : msg.val()
                    }).then(() => {
                        msg.val('');
                    });
                }
            });
            
            let channel = Echo.channel('channel-chat');
            channel.listen('ChatEvent', (e) => {
                
            });
        });
    </script>
@endsection