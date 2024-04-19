<div class="sidebar">
    <div class="logo_details">
        <i class='bx bx-code-alt'></i>
        <div class="logo_name">
            LOKAL-INDUSTRI
        </div>
    </div>
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ set_active('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="links_name">
                    Dashboard
                </span>
            </a>
        <li>
            <a href="{{ route('admin.produk') }}" class="nav-link {{ set_active('admin.produk') }}">
                <i class="fa-solid fa-shirt"></i>
                <span class="links_name">
                    Produk
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pesanan') }}"
                class="nav-link {{ set_active(['admin.pesanan', 'admin.pesanan.detail']) }}">
                <i class="fa-solid fa-truck-fast"></i>
                <span class="links_name">
                    Pesanan
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.proyek') }}" class="nav-link {{ set_active('admin.proyek') }}">
                <i class="fa-solid fa-cube"></i>
                <span class="links_name">
                    Proyek
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.laporan') }}" class="nav-link {{ set_active('admin.laporan') }}">
                <i class="fa-solid fa-book"></i>
                <span class="links_name">
                    Laporan
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.profil') }}" class="nav-link {{ set_active('admin.profil') }}">
                <i class="fa-solid fa-address-book"></i>
                <span class="links_name">
                    Profil Perusahaan
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user-manajemen') }}" class="nav-link {{ set_active('admin.user-manajemen') }}">
                <i class="fa-solid fa-users"></i>
                <span class="links_name">
                    User Manajemen
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.log') }}" class="nav-link {{ set_active('admin.log') }}" id="log">
                <i class="fa-solid fa-user-gear"></i>
                <span class="links_name">
                    Log Aktivitas
                </span>
            </a>
        </li>
        <li class="login">
            <a href="{{ route('logout') }}">
                <span class="links_name login_out">
                    Logout
                </span>
                <i class="fa-solid fa-right-from-bracket" id="log_out"></i>
            </a>
        </li>
    </ul>
</div>
