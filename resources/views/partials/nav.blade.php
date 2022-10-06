<nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{asset('icons/comment-alt.png')}}" alt="..." height="36">
            Helpdesk chat
        </a>
        @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat.home') }}">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat.ratings') }}">Ratings</a>
                    </li>
                    <li class="nav-item dropdown" id="notification-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Notifications
                            @if ($numNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" id="notif">
                                    there are {{ $numNotifications->count() }} unread notifications
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('chat.notifications') }}">All notification</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary active dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" @disabled(true)><i class="fa-solid fa-shield-halved"></i> Role: 
                            @if (auth()->user()->role() == 'staff')
                                <span class="badge bg-success">STAFF</span>
                            @elseif (auth()->user()->role() == 'admin')
                                <span class="badge bg-warning">ADMIN</span>
                            @elseif (auth()->user()->role() == 'user')
                                <span class="badge bg-primary">USER</span>
                            @endif
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('chat.profile') }}"><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('chat.logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
@auth
    <script>
        $(function() {
            const Http = window.axios
            const Echo = window.Echo
            const notif = $('#notif')
            const notifDropdown = $('#notification-dropdown')
            // const userId = {{ auth()->user()->id }}
            let numNotifications = parseInt("{{$numNotifications->count()}}")

            notifDropdown.click(function() {
                notif.removeClass('bg-danger')
                notif.text('')
                if (numNotifications > 0) {
                    Http.post('/notifications/read')
                        .then(res => {
                            numNotifications = 0
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            })

            let notificationChannel = Echo.channel('notification.'+{{ auth()->user()->id }})
            notificationChannel.listen('NotificationEvent', (e) => {
                notif.addClass('bg-danger')
                notif.text('there are '+(++numNotifications)+' unread notifications')
                // notif.text("there are unread notifications")
            });

        })
    </script>
@endauth