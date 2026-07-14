<!-- ================= SIDEBAR ================= -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <div class="logo-area">
            <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo">
            <h2>User</h2>
        </div>

        <button class="sidebar-close" onclick="closeSidebar()">
            <i class="fa-solid fa-times"></i>
        </button>

    </div>

    <ul class="menu">

        <!-- Beranda -->
        <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Beranda</span>
            </a>
        </li>

        <!-- Aspirasi -->
        <li class="{{ request()->routeIs('user.messages.*') ? 'active' : '' }}">
            <a href="{{ route('user.messages.index') }}">
                <i class="fa-solid fa-envelope"></i>
                <span>Aspirasi</span>
            </a>
        </li>

        <!-- Berita -->
        <li class="{{ request()->routeIs('user.news.*') ? 'active' : '' }}">
            <a href="{{ route('user.news.index') }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Berita</span>
            </a>
        </li>

        <!-- Galeri -->
        <li class="{{ request()->routeIs('user.gallery.*') ? 'active' : '' }}">
            <a href="{{ route('user.gallery.index') }}">
                <i class="fa-solid fa-images"></i>
                <span>Galeri</span>
            </a>
        </li>

        <!-- Logout -->
        <li class="logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>

            </form>

        </li>

    </ul>

</aside>

<!-- ================= OVERLAY ================= -->
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>
