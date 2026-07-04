<header class="main-header">
    <div class="header-container">

        <!-- Logo -->
        <div class="logo-section">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logorumahmoeda.png') }}"
                     alt="Logo Rumah Moeda"
                     class="logo-img">
            </a>

            <span class="logo-text">Rumah Moeda</span>
        </div>

        <!-- Navigation -->
        <nav class="nav-menu">
            <ul>
                <li>
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}"
                       class="{{ request()->routeIs('tentang') ? 'active' : '' }}">
                        Tentang Kami
                    </a>
                </li>

                <li>
                    <a href="{{ route('hubungi') }}"
                       class="{{ request()->routeIs('hubungi') ? 'active' : '' }}">
                        Hubungi Kami
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">

            @guest
                <a href="{{ route('login') }}" class="btn-login-reg">
                    Login | Register
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="btn-login-reg">
                    Dashboard
                </a>
            @endauth

            <button id="darkmode-toggle" class="dark-toggle">
                <i class="fas fa-moon"></i>
            </button>

        </div>

    </div>
</header>
