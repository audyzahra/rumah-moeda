@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
@endpush
@section('content')

    <div class="portfolio-page">

        {{-- ===========================================================
        HERO
    ============================================================ --}}
        <section class="portfolio-hero">

            {{-- LEFT --}}
            <div class="hero-left">

                <div class="portfolio-breadcrumb">

                    <a href="{{ url('/') }}">
                        Beranda
                    </a>

                    <span>></span>

                    <span>
                        Portofolio
                    </span>

                </div>

                <h1>

                    Portofolio
                    <br>
                    Kami

                </h1>

                <div class="hero-line"></div>

                <p>

                    Dokumentasi kerja sama dan kegiatan yang telah
                    kami lakukan bersama mitra dan komunitas.

                </p>

            </div>


            {{-- RIGHT --}}
            <div class="hero-right">

                <div class="stats-wrapper">

                    <div class="stat-box">

                        <div class="stat-icon">

                            🤝

                        </div>

                        <div>

                            <h2>

                                {{ $totalPartner }}

                            </h2>

                            <h4>

                                Mitra Kerja Sama

                            </h4>

                            <p>

                                dengan berbagai mitra

                            </p>

                        </div>

                    </div>


                    <div class="stat-box">

                        <div class="stat-icon">

                            💼

                        </div>

                        <div>

                            <h2>

                                {{ $totalPortfolio }}

                            </h2>

                            <h4>

                                Program

                            </h4>

                            <p>

                                telah dilaksanakan

                            </p>

                        </div>

                    </div>


                    <div class="stat-box">

                        <div class="stat-icon">

                            👥

                        </div>

                        <div>

                            <h2>

                                {{ number_format($totalParticipants, 0, ',', '.') }}

                            </h2>

                            <h4>

                                Peserta Terlibat

                            </h4>

                            <p>

                                dari berbagai kegiatan

                            </p>

                        </div>

                    </div>


                    <div class="stat-box">

                        <div class="stat-icon">

                            🏢

                        </div>

                        <div>

                            <h2>

                                {{ $totalCategory }}

                            </h2>

                            <h4>

                                Instansi & Komunitas

                            </h4>

                            <p>

                                telah berkolaborasi

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ===========================================================
            TOOLBAR
        ============================================================ --}}
        <div class="portfolio-content">
            <form id="portfolioFilter">
                <input
                    type="hidden"
                    name="per_page"
                    value="{{ request('per_page', 6) }}">

                <section class="portfolio-toolbar">

                    {{-- SEARCH --}}
                    <div class="toolbar-search">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2">

                            <circle cx="9" cy="9" r="7">
                            </circle>

                            <path d="M20 20l-4-4">
                            </path>

                        </svg>

                        <input
                            id="searchInput"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama kegiatan atau mitra...">

                    </div>


                    {{-- SORT --}}
                    <div class="toolbar-select">

                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2">

                            <rect x="3" y="4" width="14" height="14" rx="2">
                            </rect>

                            <path d="M8 2v4M16 2v4M3 10h14">
                            </path>

                        </svg>

                        <select id="sortFilter" name="sort">
                            <option
                                value="newest"
                                {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>
                                Terbaru
                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                Terlama
                            </option>
                        </select>

                    </div>


                    <div class="toolbar-select">

                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2">

                            <path d="M4 7h16"></path>
                            <path d="M7 12h10"></path>
                            <path d="M10 17h4"></path>

                        </svg>

                        <select id="categoryFilter" name="category">

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"
                                    {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </section>
            </form>


            {{-- ===========================================================
                GRID CARD
            ============================================================ --}}
            <section class="portfolio-grid">

                @forelse($portfolios as $portfolio)
                    <article class="portfolio-card" data-date="{{ $portfolio->activity_date }}">

                        @php
                            $image = $portfolio->media->where('type', 'image')->sortBy('display_order')->first();
                        @endphp

                        <div class="card-image">

                            @if ($image)
                                <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $portfolio->title }}">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                            @endif

                            <span class="card-category">

                                {{ $portfolio->category?->name }}

                            </span>

                        </div>

                        <div class="card-content">

                            <div class="card-date">

                                📅
                                {{ \Carbon\Carbon::parse($portfolio->activity_date)->translatedFormat('d F Y') }}

                            </div>

                            <h3>

                                {{ $portfolio->title }}

                            </h3>

                            <div class="card-location">

                                📍 {{ $portfolio->location }}

                            </div>

                            <p>

                                {{ Str::limit(strip_tags($portfolio->description), 120) }}

                            </p>

                            <a href="{{ route('portfolio.show', $portfolio) }}" class="detail-btn">

                                <span>Lihat Detail</span>

                                <span>→</span>

                            </a>

                        </div>

                    </article>

                @empty

                    <div class="empty-portfolio">

                        <div class="empty-icon">

                            <i class="fa-regular fa-folder-open"></i>

                        </div>

                        <h3>

                            Belum Ada Portofolio

                        </h3>

                        <p>

                            Portofolio yang telah dipublikasikan akan muncul di sini.
                            Silakan kembali lagi nanti.

                        </p>

                    </div>
                @endforelse

            </section>

            {{-- PAGINATION --}}
            <div class="custom-pagination">

                {{-- Show Entries --}}
                <div class="pagination-left">

                    <form method="GET" id="perPageForm">

                        {{-- Menyimpan query search/sort jika nanti ada --}}
                        @foreach (request()->except('per_page', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <span>Tampilkan</span>

                        <select name="per_page" onchange="this.form.submit()">

                            <option value="6" {{ request('per_page', 6) == 6 ? 'selected' : '' }}>
                                6
                            </option>

                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>
                                12
                            </option>

                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>
                                24
                            </option>

                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>
                                48
                            </option>

                        </select>

                        <span>Portofolio</span>

                    </form>

                </div>

                {{-- Info --}}
                <div class="pagination-center">

                    <span>Menampilkan</span>

                    <strong>{{ $portfolios->firstItem() ?? 0 }}</strong>

                    <span>-</span>

                    <strong>{{ $portfolios->lastItem() ?? 0 }}</strong>

                    <span>dari</span>

                    <strong>{{ $portfolios->total() }}</strong>

                    <span>data</span>

                </div>

                {{-- Pagination --}}
                <div class="pagination-right">

                    {{-- Previous --}}
                    @if ($portfolios->onFirstPage())
                        <button class="page-btn" disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    @else
                        <a href="{{ $portfolios->previousPageUrl() }}" class="page-btn">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Nomor Halaman PAGINATION (HANYA 2 NOMOR HALAMAN)--}}
                        @php
                            $current = $portfolios->currentPage();
                            $last = $portfolios->lastPage();

                            // Mulai dari halaman aktif
                            $start = $current;

                            // Akhir maksimal 2 halaman
                            $end = min($current + 1, $last);

                            // Kalau sudah di halaman terakhir,
                            // mundurkan supaya tetap tampil 2 angka
                            if ($end - $start < 1 && $start > 1) {
                                $start--;
                            }
                        @endphp

                        @for ($page = $start; $page <= $end; $page++)

                            @if ($page == $current)

                                <span class="page-number active">
                                    {{ $page }}
                                </span>

                            @else

                                <a href="{{ $portfolios->url($page) }}" class="page-number">
                                    {{ $page }}
                                </a>

                            @endif

                        @endfor

                    {{-- Next --}}
                    @if ($portfolios->hasMorePages())
                        <a href="{{ $portfolios->nextPageUrl() }}" class="page-btn">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="page-btn" disabled>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    @endif

                </div>

            </div>
        </div>

        {{-- ===========================================================
                CTA
            =========================================================== --}}
        @if ($portfolios->isNotEmpty())
            <section class="portfolio-cta">

                <div class="cta-decoration cta-left"></div>

                <div class="cta-decoration cta-right"></div>

                <div class="cta-content">

                    <h2>

                        Ingin Berkolaborasi dengan Rumah Moeda?

                    </h2>


                    <p>

                        Mari bersama menciptakan program dan kegiatan
                        yang bermanfaat bagi masyarakat dan bangsa.

                    </p>

                    <a href="{{ route('contact') }}" class="cta-btn">

                        <span>

                            Hubungi Kami

                        </span>

                        <span>

                            →

                        </span>

                    </a>

                </div>

            </section>
        @endif

    </div>

@endsection


@push('scripts')
    <script src="{{ asset('js/portfolio.js') }}"></script>
@endpush
