<div class="sidebar">
    <div class="logo_details">
        <i class='bx bx-code-alt'></i>
        <div class="logo_name">
            Konveksi
        </div>
    </div>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="nav-link {{ set_active('dashboard') }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="links_name">
                    Dashboard
                </span>
            </a>
        <li>
            <a href="{{ route('katalog') }}" class="nav-link {{ set_active('katalog') }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="links_name">
                    Katalog
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('user-manajemen') }}" class="nav-link {{ set_active('user-manajemen') }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="links_name">
                    User Manajemen
                </span>
            </a>
        </li>
        <li class="login">
            <a href="#">
                <span class="links_name login_out">
                    Logout
                </span>
                <i class="fa-solid fa-right-from-bracket" id="log_out"></i>
            </a>
        </li>
    </ul>
</div>
