@extends('layouts.app')

@section('title', 'Portofolio')

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

                    <input type="text" placeholder="Cari nama kegiatan atau mitra...">

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

                    <select id="sortFilter">

                        <option value="newest">
                            Terbaru
                        </option>

                        <option value="oldest">
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

                    <select id="categoryFilter">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ strtolower($category->name) }}">
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                </div>
            </section>


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

        <!-- ================= PAGINATION ================= -->

                <div class="pagination-section">

                    <div class="info-data">

                        Menampilkan

                        <strong>{{ $portfolios->firstItem() ?? 0 }}</strong>

                        -

                        <strong>{{ $portfolios->lastItem() ?? 0 }}</strong>

                        dari

                        <strong>{{ $portfolios->total() }}</strong>

                        data

                    </div>

                    <div class="pagination-controls">

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

                        <span id="pageInfo">

                            Halaman

                            {{ $portfolios->currentPage() }}

                            dari

                            {{ $portfolios->lastPage() }}

                        </span>

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
