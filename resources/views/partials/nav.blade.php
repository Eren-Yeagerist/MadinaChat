<nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{asset('icons/comment-alt.png')}}" alt="..." height="36">
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
                        @if (auth()->user()->role() == 'staff')
                            <a class="nav-link" href="{{ route('staff.chat.ratings') }}">Ratings</a>
                        @elseif (auth()->user()->role() == 'admin')
                            <a class="nav-link" href="{{ route('admin.chat.ratings') }}">Ratings</a>
                        @elseif (auth()->user()->role() == 'user')
                            <a class="nav-link" href="{{ route('user.chat.ratings') }}">Ratings</a>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Notifications<span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                99+
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action fajdskljfklasdjfkl asjdklfjasdklj</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                @if (auth()->user()->role() == 'staff')
                                    <a class="dropdown-item" href="{{ route('staff.chat.notifications') }}">Selengkapnya</a>
                                @elseif (auth()->user()->role() == 'user')
                                    <a class="dropdown-item" href="{{ route('user.chat.notifications') }}">Selengkapnya</a>
                                @endif
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary active dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{-- <i class="fa-solid fa-right-from-bracket"></i> --}}
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