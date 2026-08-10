@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/portfolio-detail.css') }}">
@endpush

@section('content')

    <div class="portfolio-detail">

        <section class="portfolio-hero">

            @php
                $heroImage = $portfolio->media->where('type', 'image')->sortBy('display_order')->first();
            @endphp

            <div class="hero-image">

                @if ($heroImage && Storage::disk('public')->exists($heroImage->file_path))
                    <img src="{{ Storage::url($heroImage->file_path) }}" alt="{{ $portfolio->title }}">
                @else
                    <img src="{{ defaultImage() }}" alt="Foto Default">
                @endif

                <div class="hero-overlay"></div>

            </div>

            <div class="hero-content container">

                <nav class="breadcrumb">

                    <a href="{{ route('home') }}">
                        Beranda
                    </a>

                    <span>/</span>

                    <a href="{{ route('portfolio.index') }}">
                        Portofolio
                    </a>

                    <span>/</span>

                    <span>
                        Detail
                    </span>

                </nav>

                <span class="category-badge">

                    {{ $portfolio->category->name }}

                </span>

                <h1>

                    {{ $portfolio->title }}

                </h1>

                <p>

                    {{ Str::limit(strip_tags($portfolio->description), 180) }}

                </p>

            </div>

        </section>
        {{-- ===========================================================
    INFORMASI KEGIATAN
=========================================================== --}}
        <section class="portfolio-info">

            <div class="container">

                <div class="info-grid">

                    {{-- Tanggal --}}
                    <div class="info-item">

                        <div class="info-icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>

                        <div class="info-content">

                            <span>Tanggal</span>

                            <strong>
                                {{ \Carbon\Carbon::parse($portfolio->activity_date)->translatedFormat('d F Y') }}
                            </strong>

                        </div>

                    </div>


                    {{-- Peserta --}}
                    <div class="info-item">

                        <div class="info-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div class="info-content">

                            <span>Peserta</span>

                            <strong>

                                {{ number_format($portfolio->participants, 0, ',', '.') }} Orang

                            </strong>

                        </div>

                    </div>

                    {{-- Mitra --}}
                    <div class="info-item">

                        <div class="info-icon">
                            <i class="fa-solid fa-handshake"></i>
                        </div>

                        <div class="info-content">

                            <span>Mitra</span>

                            <strong>

                                {{ $portfolio->partner->name }}

                            </strong>

                        </div>

                    </div>

                    {{-- Kategori --}}
                    <div class="info-item category">

                        <div class="info-icon">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>

                        <div class="info-content">

                            <span>Kategori</span>

                            <span class="category-pill">

                                {{ $portfolio->category->name }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </section>
        {{-- ===========================================================
    DETAIL CONTENT
=========================================================== --}}
        <section class="portfolio-content-section">

            <div class="container">

                <div class="content-grid">

                    {{-- KONTEN KIRI --}}
                    <div class="content-main">

                        <div class="content-card">

                            <div class="section-title">

                                <h2>Tentang Kegiatan</h2>

                                <span></span>

                            </div>

                            <div class="portfolio-description">

                                {!! $portfolio->description !!}

                            </div>

                        </div>

                    </div>

                    {{-- SIDEBAR KANAN --}}
                    <aside class="content-sidebar">

                        <div class="location-card">

                            <div class="info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>

                            <div class="info-content">

                                <span>Lokasi</span>

                                <p class="location-text">
                                    {{ $portfolio->location }}
                                </p>

                            </div>

                        </div>

                    </aside>

                </div>

                {{-- ===========================================================
    GALERI DOKUMENTASI
=========================================================== --}}
                <section class="portfolio-gallery">

                    <div class="container">

                        <div class="section-heading">

                            <h2>

                                Galeri Dokumentasi

                            </h2>

                        </div>

                        @if ($portfolio->media->count())
                            <div class="gallery-grid">

                                @foreach ($portfolio->media->sortBy('display_order') as $media)
                                    {{-- FOTO --}}
                                    @if ($media->type === 'image')
                                        @if (Storage::disk('public')->exists($media->file_path))
                                            <a href="{{ Storage::url($media->file_path) }}" class="gallery-item">

                                                <img src="{{ Storage::url($media->file_path) }}"
                                                    alt="{{ $portfolio->title }}">

                                                <div class="gallery-overlay">
                                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                                </div>

                                            </a>
                                        @else
                                            <div class="gallery-item">

                                                <img src="{{ defaultImage() }}" alt="Foto Default">

                                            </div>
                                        @endif


                                        {{-- VIDEO YOUTUBE --}}
                                    @elseif ($media->type === 'video')
                                        @php
                                            preg_match(
                                                '/(?:youtu\.be\/|youtube\.com\/watch\?v=|youtube\.com\/embed\/)([^?&]+)/',
                                                $media->video_url,
                                                $matches,
                                            );

                                            $youtubeId = $matches[1] ?? null;
                                        @endphp

                                        @if ($youtubeId)
                                            <div class="gallery-item gallery-video">

                                                <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                    title="YouTube video" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>

                                            </div>
                                        @else
                                            <div class="gallery-item">

                                                <img src="{{ defaultImage('video') }}" alt="Video Default">

                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                            </div>
                        @else
                            {{-- Tidak ada media sama sekali --}}
                            <div class="gallery-item">

                                <img src="{{ defaultImage() }}" alt="Foto Default">

                            </div>
                        @endif
                    </div>

                </section>

                {{-- ==========================================
    TENTANG MITRA
========================================== --}}
                <div class="content-card partner-card">

                    <div class="section-title">

                        <h2>

                            Mitra Kolaborasi

                        </h2>

                        <span></span>

                    </div>

                    <div class="partner-card-horizontal">

                        <div class="partner-logo">

                            @if ($portfolio->partner && $portfolio->partner->logo && Storage::disk('public')->exists($portfolio->partner->logo))
                                <img src="{{ Storage::url($portfolio->partner->logo) }}"
                                    alt="{{ $portfolio->partner->name }}">
                            @else
                                <img src="{{ defaultImage() }}" alt="Foto Default">
                            @endif

                        </div>

                        <div class="partner-content">

                            <span class="partner-label">
                                Partner Resmi Rumah Moeda
                            </span>

                            <h3>{{ $portfolio->partner?->name }}</h3>

                            @if ($portfolio->partner?->description)
                                <p>
                                    {{ $portfolio->partner->description }}
                                </p>
                            @endif

                            @if ($portfolio->partner?->website)
                                <a href="{{ $portfolio->partner->website }}" target="_blank" class="partner-link">

                                    Website Partner

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>
                            @endif

                        </div>

                    </div>

                </div>
                <section class="related-portfolio">

                    <div class="container">

                        <div class="section-heading">

                            <h2>

                                Portofolio Lainnya

                            </h2>

                        </div>

                        <div class="related-grid">

                            @forelse($relatedPortfolios as $item)
                                @php
                                    $thumbnail = $item->thumbnail;
                                @endphp

                                <article class="related-card">

                                    <a href="{{ route('portfolio.show', $item->slug) }}">

                                        <div class="related-image">

                                            @if ($thumbnail && Storage::disk('public')->exists($thumbnail->file_path))
                                                <img src="{{ Storage::url($thumbnail->file_path) }}"
                                                    alt="{{ $item->title }}">
                                            @else
                                                <img src="{{ defaultImage() }}" alt="Foto Default">
                                            @endif

                                            <span class="related-category">

                                                {{ $item->category->name }}

                                            </span>

                                        </div>

                                        <div class="related-content">

                                            <div class="related-date">

                                                <i class="fa-regular fa-calendar"></i>

                                                {{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d F Y') }}

                                            </div>

                                            <h3>

                                                {{ Str::limit($item->title, 60) }}

                                            </h3>

                                            <p>

                                                {{ Str::limit(strip_tags($item->description), 80) }}

                                            </p>

                                            <span class="related-link">

                                                Lihat Detail

                                                <i class="fa-solid fa-arrow-right"></i>

                                            </span>

                                        </div>

                                    </a>

                                </article>

                            @empty

                                <div class="empty-related">

                                    Belum ada portofolio lainnya.

                                </div>
                            @endforelse

                        </div>

                    </div>

                </section>
                {{-- ===========================================================
    CTA
=========================================================== --}}
                <section class="portfolio-cta">

                    <div class="container">

                        <div class="cta-card">

                            <div class="cta-content">

                                <span class="cta-badge">

                                    🤝 Kolaborasi Bersama Rumah Moeda

                                </span>

                                <h2>

                                    Tertarik Berkolaborasi Bersama Kami?

                                </h2>

                                <p>

                                    Rumah Moeda membuka kesempatan kerja sama dengan berbagai
                                    instansi, komunitas, sekolah, perguruan tinggi, maupun
                                    organisasi untuk menciptakan program yang memberikan dampak
                                    positif bagi masyarakat.

                                </p>

                            </div>

                            <div class="cta-action">

                                <a href="{{ route('contact') }}" class="cta-btn">

                                    Hubungi Kami

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        @endsection

        @push('scripts')
            <script src="{{ asset('js/portfolio-detail.js') }}"></script>
        @endpush
