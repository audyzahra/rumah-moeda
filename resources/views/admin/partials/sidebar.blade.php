<!-- ================= SIDEBAR ================= -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <div class="logo-area">
            <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo">
            <h2>Admin</h2>
        </div>

        <button class="sidebar-close" onclick="closeSidebar()">
            <i class="fa-solid fa-times"></i>
        </button>

    </div>

    <ul class="menu">

        <!-- Beranda -->
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Beranda</span>
            </a>
        </li>

        <!-- Aspirasi -->
        <li class="{{ request()->routeIs('admin.aspirasi.*') ? 'active' : '' }}">
            <a href="{{ route('admin.aspirasi.index') }}">
                <i class="fa-solid fa-envelope"></i>
                <span>Aspirasi</span>

                
                <span class="badge">12</span>
            </a>
        </li>

        <!-- Berita -->
        <li class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <a href="{{ route('admin.berita.index') }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Berita</span>


                <span class="badge">8</span>
            </a>
        </li>

        <!-- Gallery -->
        <li class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <a href="{{ route('admin.gallery.index') }}">
                <i class="fa-solid fa-images"></i>
                <span>Gallery</span>


                <span class="badge">15</span>
            </a>
        </li>

        <!-- Struktur Organisasi -->
        <li class="{{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}">
            <a href="{{ route('admin.struktur.index') }}">
                <i class="fa-solid fa-sitemap"></i>
                <span>Struktur Organisasi</span>


                <span class="badge">6</span>
            </a>
        </li>

        <!-- Mitra -->
        <li class="{{ request()->routeIs('admin.mitra.*') ? 'active' : '' }}">
            <a href="{{ route('admin.mitra.index') }}">
                <i class="fa-solid fa-handshake"></i>
                <span>Mitra</span>


                <span class="badge">4</span>
            </a>
        </li>

        <!-- FAQ -->
        <li class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
            <a href="{{ route('admin.faq.index') }}">
                <i class="fa-solid fa-circle-question"></i>
                <span>FAQ</span>


                <span class="badge">5</span>
            </a>
        </li>

        <!-- Pengaturan -->
        <li class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
            <a href="{{ route('admin.pengaturan') }}">
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan</span>
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

<!-- ===== OVERLAY ===== -->
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>
