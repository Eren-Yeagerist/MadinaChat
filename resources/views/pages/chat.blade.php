@extends('layouts.main')
@section('title'){{ 'Chat' }}@endsection
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div class="p-2">
            <h3>| {{ $chat->title }} | <i class="fa-solid fa-comment"></i></h3>
        </div>
        <div class="p-2 row">
            <div class="col p-1">
                <a href="{{ route('chat.chat', $chat) }}" class="btn btn-secondary active position-relative">
                    Refresh
                    <span><i class="fa-solid fa-arrows-rotate"></i></span>
                </a>
            </div>

            <div class="col p-1">
                @if ($chat->status()['status'] != 'finished')
                    <form class="form-inline" action="{{ route('user.chat.end', $chat) }}" method="post" enctype="multipart/form-data" onclick="return confirm('Are you sure to end this chat session')">
                        @csrf 
                        @method('PUT')
                        <input type="submit" class="btn btn-danger" value="End chat session">
                    </form>   
                @endif
            </div>
        </div>
    </div>

    <div class="chat border p-3">
        {{-- Chat Timeline --}}
        @foreach ($messages as $message)
            @if (auth()->user()->id == $message->user_id)
                <div class="card border-success rounded-0 mb-2 w-75 float-end">
            @else
                <div class="card border-primary rounded-0 mb-2 w-75 float-left">
            @endif
                <div class="card-body" id="msg{{ $message->id }}">
                    <b>{{ $message->user->name }}</b> | <small>{{ $message->user->role() }}</small> | <small>{{ $message->created_at }}</small>
                    @if ($message->deleted_at == null)
                        <p class="card-text">
                            {{ $message->message }}
                            @if (auth()->user()->id == $message->user_id)
                                <br><a href="{{ route('chat.message.delete', $message->id) }}" onclick="return confirm('Are you sure delete this message ?')" class="text-decoration-none badge bg-danger">delete</a>
                            @endif
                        </p>
                    @else 
                        <p class="card-text">----------------- Message has been deleted -----------------</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-md-auto position-relative bottom-0 w-50 mt-2">
        <div class="d-flex justify-content-center">
            @if ($chat->status()['status'] != 'finished')
                <div class="w-100">
                    <textarea name="msg" id="msg" class="form-control mb-2" cols="30" rows="5" required></textarea>
                    <div id="validation" class="invalid-feedback">
                        Please enter a message.
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" id="send_msg">
                        <span>send</span>
                    </button>
                </div>
            @else
                <div class="w-100 mb-4">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Chat session is finished! </h4>
                        @if (auth()->user()->role() == 'staff')
                            <a href="{{ route('chat.chat.unlock', $chat->slug) }}" class="btn btn-success active position-relative">
                                Unlock
                                <i class="fa-sharp fa-solid fa-lock-open"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        let lastMsgId = "msg{{ (!$messages->isEmpty()) ? $messages->last()->id : 0 }}";
        
        if (lastMsgId != 'msg0') {
            let lastMsg = document.getElementById(lastMsgId);
            lastMsg.scrollIntoView({ behavior: 'smooth' })
        }
       
        $(function() {
            const Http = window.axios;
            const Echo = window.Echo;
            const name = "{{ Auth::user()->name }}";
            const user_id = "{{ Auth::user()->id }}";
            const chat_id = "{{ $chat->id }}";
            const chat_slug = "{{ $chat->slug }}";
            const status = "{{ $chat->status }}";
            const msg = $('#msg');

            $('#msg').on('keyup', function() {
                $(this).removeClass('is-invalid');
            });

            $('#send_msg').click(function() {
                $('#send_msg').prop('disabled', true);
                $('#send_msg').html('sending...<span class="spinner-grow spinner-grow-sm" id="spinner" role="status" aria-hidden="true"></span>')

                if (msg.val() == '') {
                    msg.addClass('is-invalid');
                    $('#send_msg').prop('disabled', false);
                    $('#send_msg').html('send');

                } else {
                    Http.post("{{ route('chat.send') }}", {
                        'name' : name,
                        'user_id': user_id,
                        'session_id': chat_id,
                        'status' : status,
                        'slug' : chat_slug,
                        'message' : msg.val()
                    }).then(() => {
                        msg.val('');
                    });
                }
            });
            
            
            let channel = Echo.channel('channel-chat');
            channel.listen('ChatEvent', (e) => {
                if (e.message.session_id == chat_id) {
                    let idMsg = e.message.id;
                    let color = 'primary float-start';
                    let button = '';
                    let flag = (e.message.user_id == "{{ Auth::user()->id }}" ? true : false);

                    if (flag) {
                        color = 'success float-end';
                        button = `<br><a href="/chat/${idMsg}/delete" class="text-decoration-none badge bg-danger" onclick="return confirm('Are you sure delete this message ?')" >delete</a>`;
                    } 

                    $('.chat').append(`
                        <div class="card border-${color} rounded-0 mb-2 w-75" id="msg${e.message.id}">
                            <div class="card-body">
                                <b>${e.message.name}</b> | <small>${e.message.role}</small> | <small>${e.message.created_at}</small>
                                <p class="card-text">
                                    ${e.message.message}
                                    ${button}
                                </p>
                            </div>
                        </div>
                    `);

                    $('#send_msg').prop('disabled', false);
                    $('#send_msg').html('send');

                    lastMsg = document.getElementById("msg" + e.message.id);
                    lastMsg.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
    </script>
@endsection