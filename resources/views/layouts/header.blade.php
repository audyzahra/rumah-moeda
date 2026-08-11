<header class="main-header">

    @php
        $isUser = auth()->check() && auth()->user()->role === 'user';

        $homeRoute = $isUser ? 'member.home' : 'home';
        $aboutRoute = $isUser ? 'member.about' : 'about';
        $contactRoute = $isUser ? 'member.contact' : 'contact';

        $newsRoute = $isUser ? 'member.news.index' : 'news.index';
        $portfolioRoute = $isUser ? 'member.portfolio.index' : 'portfolio.index';

        $photoRoute = $isUser ? 'member.gallery.photos' : 'gallery.photos';
        $videoRoute = $isUser ? 'member.gallery.videos' : 'gallery.videos';

        $faqRoute = $isUser ? 'member.faq.index' : 'faq.index';
    @endphp


    <div class="header-container">

        {{-- Logo --}}
        <div class="logo-section">

            @php
                $logo =
                    $setting->website_logo && Storage::disk('public')->exists($setting->website_logo)
                        ? Storage::disk('public')->url($setting->website_logo)
                        : defaultImage('logo');
            @endphp

            <img src="{{ $logo }}" class="logo-img" alt="{{ $setting->website_name ?? 'Logo' }}">

            <a href="{{ route($homeRoute) }}" class="logo-text">
                {{ $setting->website_name }}
            </a>
        </div>

        <!-- Hamburger -->
        <div class="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>

        {{-- Navigation --}}
        <nav class="nav-menu">
            <ul>

                <li>
                    <a href="{{ route($homeRoute) }}" class="{{ request()->routeIs($homeRoute) ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route($aboutRoute) }}" class="{{ request()->routeIs($aboutRoute) ? 'active' : '' }}">
                        Tentang Kami
                    </a>
                </li>

                <li>
                    <a href="{{ route($contactRoute) }}"
                        class="{{ request()->routeIs($contactRoute) ? 'active' : '' }}">
                        Hubungi Kami
                    </a>
                </li>
                <li class="dropdown">

                    <a href="#">

                        Informasi

                        <i class="fa-solid fa-chevron-down"></i>

                    </a>

                    <ul class="dropdown-menu-nav">

                        <li>
                            <a href="{{ route($newsRoute) }}">
                                Berita
                            </a>
                        </li>

                        <li>
                            <a href="{{ route($portfolioRoute) }}">
                                Portofolio
                            </a>
                        </li>

                    </ul>

                </li>

                <li class="dropdown">

                    <a href="#">

                        Galeri

                        <i class="fa-solid fa-chevron-down"></i>

                    </a>

                    <ul class="dropdown-menu-nav">

                        <li>

                            <a href="{{ route($photoRoute) }}">

                                Foto

                            </a>

                        </li>

                        <li>

                            <a href="{{ route($videoRoute) }}">
                                Video
                            </a>

                        </li>

                    </ul>

                </li>

                <li>
                    <a href="{{ route($faqRoute) }}" class="{{ request()->routeIs($faqRoute) ? 'active' : '' }}">
                        FAQ
                    </a>
                </li>

            </ul>
        </nav>
        <div class="menu-overlay"></div>
        {{-- Header Action --}}
        <div class="header-actions">


            @auth


                {{-- Dark Mode --}}
                <button id="darkmode-toggle" class="dark-toggle">
                    <i class="fas fa-moon"></i>
                </button>

                {{-- User Dropdown --}}

            @endauth

            @guest
                <button id="darkmode-toggle" class="dark-toggle">
                    <i class="fas fa-moon"></i>
                </button>
            @endguest

        </div>

    </div>
</header>
