<input type="checkbox" id="nav-check" class="nav-check">
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            Food<span>Order</span>
        </a>

        <div class="navbar-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Beranda
            </a>
            <a href="{{ route('profile.history') }}" class="nav-link {{ request()->routeIs('profile.history') ? 'active' : '' }}">
                Riwayat
            </a>
            <a href="{{ route('addresses.index') }}" class="nav-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
                Alamat
            </a>

            <details class="nav-dropdown">
                <summary>{{ Auth::user()->name }} &#9660;</summary>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-dropdown-item">Keluar</button>
                    </form>
                </div>
            </details>
        </div>

        <label for="nav-check" class="hamburger">&#9776;</label>
    </div>

    <div class="navbar-mobile">
        <div class="mob-user">
            {{ Auth::user()->name }} &mdash; {{ Auth::user()->email }}
        </div>
        <a href="{{ route('home') }}" class="mob-link">Beranda</a>
        <a href="{{ route('profile.history') }}" class="mob-link">Riwayat Pesanan</a>
        <a href="{{ route('addresses.index') }}" class="mob-link">Alamat Saya</a>
        <a href="{{ route('profile.edit') }}" class="mob-link">Profil Saya</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mob-btn">Keluar</button>
        </form>
    </div>
</nav>
