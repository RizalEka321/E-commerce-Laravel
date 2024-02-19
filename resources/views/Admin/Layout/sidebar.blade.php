<div class="sidebar">
    <div class="logo_details">
        <i class='bx bx-code-alt'></i>
        <div class="logo_name">
            Konveksi
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
            <a href="{{ route('admin.katalog') }}" class="nav-link {{ set_active('admin.katalog') }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="links_name">
                    Katalog
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user-manajemen') }}" class="nav-link {{ set_active('admin.user-manajemen') }}">
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
