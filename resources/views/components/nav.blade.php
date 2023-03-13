<nav class="navbar navbar-expand-md navbar-light border-bottom py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img class="mx-2" src="{{ asset('assets/images/logo-unpak.webp') }}" alt="logo-unpak" height="48px">
            <img class="mx-2" src="{{ asset('assets/images/kampus-merdeka.png') }}" alt="kampus-merdeka" height="32px">
        </a>
        <button class="navbar-toggler rounded-pill border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('landing') }}" class="nav-link rounded-5 p-3 fw-semibold">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('research') }}" class="nav-link rounded-5 p-3 fw-semibold">Research</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('requestForm') }}" class="nav-link rounded-5 p-3 fw-semibold">Request</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about') }}" class="nav-link rounded-5 p-3 fw-semibold">About</a>
                </li>
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link rounded-5 p-3 fw-semibold" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                {{-- @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link rounded-5 fw-semibold" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif --}}
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link rounded-5 p-3 dropdown-toggle fw-semibold" href="#"
                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end rounded-5 border-0 bg-primary-subtle"
                        aria-labelledby="navbarDropdown">
                        <ul class="list-group list-group-flush bg-transparent">
                            <li class="list-group-item bg-transparent">
                                <a class="dropdown-item fw-semibold text-primary material-subtle"
                                    href="{{ route('home') }}">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li class="list-group-item bg-transparent">
                                <a class="dropdown-item fw-semibold text-primary material-subtle"
                                    href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>