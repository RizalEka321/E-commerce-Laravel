<nav class="navbar navbar-expand-lg navbar-light fixed-top" data-aos="fade-down">
    <div class="container">
        @if (Request::is('/'))
            <a href="{{ route('home') }}" class="navbar-brand" id="logo_navbar">
                <img src="{{ asset('assets/pembeli/img/logonavbar_putih.png') }}" alt="" width="100%"
                    height="50px">
            </a>
        @else
            <a href="{{ route('home') }}" class="navbar-brand" id="logo_navbar">
                <img src="{{ asset('assets/pembeli/img/logonavbar_hitam.png') }}" alt="" width="100%"
                    height="50px">
            </a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars py-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto nav-center">
                @if (!Request::is('checkout'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#profil">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#produk">
                            Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#kontak">
                            Kontak
                        </a>
                    </li>
                    @auth
                        @if (Auth::user()->role == 'Pembeli')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('keranjang') }}"><i class="fas fa-shopping-cart"></i>
                                </a>
                            </li>
                        @elseif (Auth::user()->role == 'Pemilik')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa fa-wrench"></i>
                                    Admin
                                    CMS</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->foto == null)
                                    <i class="fa-solid fa-user"></i>
                                @else
                                    <img src="{{ asset(Auth::user()->foto) }}" class="rounded img-fluid preview"
                                        style="width: 20px; height: 20px;" />
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (auth()->user()->role == 'Pemilik')
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                @elseif (auth()->user()->role == 'Pegawai')
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                @elseif(auth()->user()->role == 'Pembeli')
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Akun Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pesanan_saya') }}">Pesanan Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                @endif
                            </ul>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-user"></i> Login</a>
                        </li>
                    @endguest
                @endif
            </ul>
        </div>
    </div>
</nav>
