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

                @if ($jumlahNotifSidebar > 0)
                    <span class="badge">
                        {{ $jumlahNotifSidebar }}
                    </span>
                @else
                    <span class="badge badge-zero">
                        0
                    </span>
                @endif

            </a>

        </li>

        <!-- Berita -->
        <li class="has-submenu">

            <a href="#" class="submenu-toggle">

                <i class="fa-solid fa-newspaper"></i>

                <span>Berita</span>

                <i class="fa-solid fa-chevron-down submenu-arrow"></i>

            </a>

            <ul id="submenuBerita" class="submenu">

                <li>
                    <a href="{{ route('admin.berita.index') }}">
                        Berita
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.kategori.index') }}">
                        Kategori
                    </a>
                </li>

            </ul>

        </li>

        <!-- Gallery -->
        <li class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <a href="{{ route('admin.gallery.index') }}">
                <i class="fa-solid fa-images"></i>
                <span>Galeri</span>

                <!--
                <span class="badge">15</span> -->
            </a>
        </li>

        <!-- Struktur Organisasi -->
        <li class="{{ request()->routeIs('admin.organization-structures.*') ? 'active' : '' }}">
            <a href="{{ route('admin.organization-structures.index') }}">
                <i class="fa-solid fa-sitemap"></i>
                <span>Struktur Organisasi</span>


                <!-- <span class="badge">6</span> -->
            </a>
        </li>

        <!-- Mitra -->
        <li class="{{ request()->routeIs('admin.mitra.*') ? 'active' : '' }}">
            <a href="{{ route('admin.mitra.index') }}">
                <i class="fa-solid fa-handshake"></i>
                <span>Mitra</span>
                <!-- <span class="badge">4</span> -->
            </a>
        </li>

        <!-- FAQ -->
        <li class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
            <a href="{{ route('admin.faq.index') }}">
                <i class="fa-solid fa-circle-question"></i>
                <span>FAQ</span>
                <!-- <span class="badge">5</span> -->
            </a>
        </li>

        <!-- Kelola Akun -->
        <li class="{{ request()->routeIs('admin.manage-account.*') ? 'active' : '' }}">
            <a href="{{ route('admin.manage-account.index') }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Kelola Akun</span>
            </a>
        </li>

        <!-- Pengaturan -->
        <li class="has-submenu-setting {{ request()->routeIs('admin.settings.*') ? 'open active' : '' }}">

            <a href="#" class="submenu-toggle-setting">
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan</span>
                <i class="fa-solid fa-chevron-down submenu-arrow-setting"></i>
            </a>

            <ul id="submenuPengaturan" class="submenu">
                <li>
                    <a href="{{ route('admin.settings.hero.index') }}"
                        class="{{ request()->routeIs('admin.settings.hero.*') ? 'active' : '' }}">
                        Hero Section
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.profile.index') }}"
                        class="{{ request()->routeIs('admin.settings.profile.*') ? 'active' : '' }}">
                        Profil Perusahaan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.visi.index') }}"
                        class="{{ request()->routeIs('admin.settings.visi.*') ? 'active' : '' }}">
                        Visi Misi
                    </a>
                </li>

            </ul>

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
