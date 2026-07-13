<header class="main-header">
    <div class="header-container">

        {{-- Logo --}}
        <div class="logo-section">
            <a href="{{ route('home') }}">
                @if (!empty($setting->website_logo))
                    <img src="{{ Storage::url($setting->website_logo) }}" class="logo-img"
                        alt="{{ $setting->website_name }}">
                @else
                    <img src="{{ asset('assets/logo-default.png') }}" class="logo-img" alt="Logo">
                @endif
            </a>

            <span class="logo-text">
                {{ $setting->website_name }}
            </span>
        </div>

        <!-- Hamburger -->
        <div class="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>

        {{-- Navigation --}}
        <nav class="nav-menu">
            <ul>

                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">
                        Tentang Kami
                    </a>
                </li>

                <li>
                    <a href="{{ route('hubungi') }}" class="{{ request()->routeIs('hubungi') ? 'active' : '' }}">
                        Hubungi Kami
                    </a>
                </li>

                <li>
                    <a href="{{ route('berita.index') }}"
                        class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        Berita
                    </a>
                </li>

                <li>
                    <a href="{{ route('galeri.index') }}"
                        class="{{ request()->routeIs('galeri.*') ? 'active' : '' }}">
                        Galeri
                    </a>
                </li>

                <li>
                    <a href="{{ route('faq.index') }}" class="{{ request()->routeIs('faq.*') ? 'active' : '' }}">
                        Pertanyaan
                    </a>
                </li>

            </ul>
        </nav>
        <div class="menu-overlay"></div>
        {{-- Header Action --}}
        <div class="header-actions">

            @guest

                <div class="auth-buttons">

                    <a href="{{ route('login') }}" class="btn-login">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn-register">
                        Register
                    </a>

                </div>

            @endguest


            @auth

                {{-- Dashboard --}}
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-login-reg">
                        Dashboard
                    </a>
                @elseif (auth()->user()->role == 'user')
                    <a href="{{ route('dashboard') }}" class="btn-login-reg">
                        Dashboard
                    </a>
                @endif

                {{-- Dark Mode --}}
                <button id="darkmode-toggle" class="dark-toggle">
                    <i class="fas fa-moon"></i>
                </button>

                {{-- User Dropdown --}}
                <div class="user-dropdown">

                    <button class="user-btn" id="userMenuBtn">
                        <i class="fas fa-user-circle"></i>
                    </button>

                    <div class="dropdown-menu" id="userDropdown">

                        <a href="{{ route('profile.edit') }}">
                            <i class="fas fa-user"></i>
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            @endauth

            @guest
                <button id="darkmode-toggle" class="dark-toggle">
                    <i class="fas fa-moon"></i>
                </button>
            @endguest

        </div>

    </div>
</header>
