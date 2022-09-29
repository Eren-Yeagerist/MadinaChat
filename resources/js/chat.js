$(function () {
    const Http = window.axios;
    const Echo = window.Echo;
    const name = "{{ Auth::user()->name }}";
    const user_id = "{{ Auth::user()->id }}";
    const chat_id = "{{ $chat->id }}";
    const msg = $('#msg');

    $('#msg').on('keyup', function () {
        $(this).removeClass('is-invalid');
    });

    $('#send_msg').click(function () {
        if (msg.val() == '') {
            msg.addClass('is-invalid');
        } else {
            Http.post("{{ route('chat.send') }}", {
                'name': name,
                'user_id': user_id,
                'session_id': chat_id,
                'message': msg.val()
            }).then(() => {
                msg.val('');
            });
        }
    });

    let color = 'primary';
    let flag = (user_id == "{{ Auth::user()->id }}" ? true : false);

    if (flag == true) {
        color = 'success';
    }

    let channel = Echo.channel('channel-chat');
    channel.listen('ChatEvent', (e) => {
        console.log(e);
        $('.chat').append(`
                    <div class="card border-${color} rounded-0 mb-2">
                        <div class="card-body">
                            <b>${e.message.name}</b> | <small></small>
                            <p class="card-text">${e.message.message}</p>
                        </div>
                    </div>
                `);
    });
});