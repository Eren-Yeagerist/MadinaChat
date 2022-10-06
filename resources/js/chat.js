let lastMsgId = "msg{{ (!$messages->isEmpty()) ? $messages->last()->id : 0 }}";

if (lastMsgId != 'msg0') {
    let lastMsg = document.getElementById(lastMsgId);
    lastMsg.scrollIntoView({ behavior: 'smooth' })
}

$(function () {
    const Http = window.axios;
    const Echo = window.Echo;
    const name = "{{ Auth::user()->name }}";
    const user_id = "{{ Auth::user()->id }}";
    const chat_id = "{{ $chat->id }}";
    const chat_slug = "{{ $chat->slug }}";
    const status = "{{ $chat->status }}";
    const msg = $('#msg');

    $('#msg').on('keyup', function () {
        $(this).removeClass('is-invalid');
    });

    $('#send_msg').click(function () {
        $('#send_msg').prop('disabled', true);
        $('#send_msg').html('sending...<span class="spinner-grow spinner-grow-sm" id="spinner" role="status" aria-hidden="true"></span>')

        if (msg.val() == '') {
            msg.addClass('is-invalid');
            $('#send_msg').prop('disabled', false);
            $('#send_msg').html('send');

        } else {
            Http.post("{{ route('chat.send') }}", {
                'name': name,
                'user_id': user_id,
                'session_id': chat_id,
                'status': status,
                'slug': chat_slug,
                'message': msg.val()
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