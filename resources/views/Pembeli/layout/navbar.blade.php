<style>
    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: #fff;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('pembeli.dashboard') }}" class="navbar-brand">
            {{-- <img src="/images/logo.svg" alt="Logo" /> --}}
            LOKAL-INDUSTRI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars py-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pembeli.dashboard') }}"><i class="fa-solid fa-house "></i>
                        Home</a>
                </li>
            </ul> --}}
            <ul class="navbar-nav ms-auto nav-center">
                {{-- @auth
                    @if (Auth::user()->role == 'reseller')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('keranjang') }}">Keranjang <i
                                    class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        @livewire('notif')
                    @elseif (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.admin') }}"><i class="fa fa-wrench"></i> Admin
                                CMS</a>
                        @elseif (Auth::user()->role == 'pengusaha')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.pengusaha') }}"><i class="fa fa-wrench"></i>
                                Pengusaha
                                CMS</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->user()->avatar == null)
                                {{ auth()->user()->username }} <i class="fa-regular fa-circle-user fa-flip fa-lg"></i>
                            @else
                                {{ auth()->user()->username }} <img
                                    src="{{ asset('assets/users/' . Auth::user()->role . '/' . Auth::user()->id . '/avatar/' . Auth::user()->avatar) }}"
                                    id="preview" class="rounded img-fluid" style="width: 20px; height: 20px;" />
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if (auth()->user()->role == 'pengusaha')
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @elseif (auth()->user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @elseif(auth()->user()->role == 'reseller')
                                <li><a class="dropdown-item" href="{{ route('profile.reseller') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('pesanan.saya') }}">Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endauth --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pembeli.dashboard') }}"><i class="fa-solid fa-house "></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pembeli.keranjang') }}"><i class="fas fa-shopping-cart"></i>
                            Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success nav-link px-4" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
