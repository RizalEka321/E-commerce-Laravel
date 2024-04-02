<nav class="navbar navbar-expand-lg navbar-light fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            {{-- <img src="/images/logo.svg" alt="Logo" /> --}}
            LOKAL-INDUSTRI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars py-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto nav-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Home</a>
                    </li>
                    @if (Request::is('/'))
                        <li class="nav-item">
                            <a class="nav-link" href="#profil">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#produk">
                                Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">
                                Kontak
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'Pembeli')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('keranjang') }}">Keranjang <i
                                    class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    @elseif (Auth::user()->role == 'Pemilik')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa fa-wrench"></i> Admin
                                CMS</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->user()->avatar == null)
                                {{ auth()->user()->username }} <i class="fa-regular fa-circle-user fa-flip fa-lg"></i>
                            @else
                                {{ auth()->user()->username }} <img src="#" id="preview" class="rounded img-fluid"
                                    style="width: 20px; height: 20px;" />
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if (auth()->user()->role == 'Pemilik')
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @elseif (auth()->user()->role == 'Pegawai')
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @elseif(auth()->user()->role == 'Pembeli')
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('pesanan_saya') }}">Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                            @endif
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Home</a>
                    </li>
                    @if (Request::is('/'))
                        <li class="nav-item">
                            <a class="nav-link" href="#profil">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#produk">
                                Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">
                                Kontak
                            </a>
                        </li>
                    @endif
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
