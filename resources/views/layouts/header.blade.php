<header class="main-header">
    <div class="header-container">

        {{-- Logo --}}
        <div class="logo-section">
            <a href="{{ route('home') }}">
                <img src="{{ asset($setting->website_logo) }}" class="logo-img" alt="{{ $setting->website_name }}">
            </a>

            <span class="logo-text">
                {{ $setting->website_name }}
            </span>
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

                {{-- Menu khusus User --}}
                @auth
                    @if (auth()->user()->role == 'user')
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
                    @endif
                @endauth

            </ul>
        </nav>

        {{-- Header Action --}}
        <div class="header-actions">

            @guest

                <a href="{{ route('login') }}" class="btn-login-reg">
                    Login | Register
                </a>

            @endguest


            @auth

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('dashboard') }}" class="btn-login-reg">
                        Dashboard
                    </a>
                @else
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
                @endif

            @endauth

            @guest
                <button id="darkmode-toggle" class="dark-toggle">
                    <i class="fas fa-moon"></i>
                </button>
            @endguest

        </div>

    </div>
</header>
