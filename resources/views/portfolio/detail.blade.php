@extends('Layouts.app')

@section('title', 'Detail Portofolio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/portfolio-detail.css') }}">
@endpush

@section('content')

<div class="portfolio-detail-page">

    {{-- =========================
        BREADCRUMB
    ========================== --}}
    <div class="portfolio-breadcrumb">

        <a href="{{ url('/') }}">Beranda</a>

        <span>/</span>

        <a href="{{ route('portfolio.index') }}">Portofolio</a>

        <span>/</span>

        <strong>Pelatihan Literasi Digital</strong>

    </div>


    {{-- =========================
        HEADER
    ========================== --}}
    <section class="portfolio-header">

        <div class="portfolio-cover">

            <img src="{{ asset('images/demo/portfolio-1.jpg') }}" alt="Portfolio">

        </div>

        <div class="portfolio-information">

            <span class="portfolio-category">

                Pelatihan

            </span>

            <h1>

                Pelatihan Literasi Digital bersama
                Politeknik Negeri Indramayu

            </h1>

            <div class="portfolio-meta">

                <div>

                    <strong>Mitra</strong>

                    <span>Politeknik Negeri Indramayu</span>

                </div>

                <div>

                    <strong>Tanggal</strong>

                    <span>20 Mei 2026</span>

                </div>

                <div>

                    <strong>Lokasi</strong>

                    <span>Indramayu</span>

                </div>

                <div>

                    <strong>Peserta</strong>

                    <span>120 Orang</span>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================
        DESCRIPTION
    ========================== --}}
    <section class="portfolio-description">

        <h2>

            Deskripsi

        </h2>

        <p>

            Rumah Moeda bersama Politeknik Negeri Indramayu
            menyelenggarakan pelatihan literasi digital
            sebagai bentuk peningkatan kemampuan teknologi
            bagi masyarakat dan generasi muda.

        </p>

        <p>

            Kegiatan ini membahas penggunaan internet
            secara sehat, keamanan digital, pemanfaatan
            AI, serta praktik langsung menggunakan
            berbagai aplikasi produktivitas.

        </p>

    </section>


    {{-- =========================
        GALLERY
    ========================== --}}
    <section class="portfolio-gallery">

        <h2>

            Dokumentasi Kegiatan

        </h2>

        <div class="gallery-grid">

            <img src="{{ asset('images/demo/gallery1.jpg') }}" alt="">

            <img src="{{ asset('images/demo/gallery2.jpg') }}" alt="">

            <img src="{{ asset('images/demo/gallery3.jpg') }}" alt="">

            <img src="{{ asset('images/demo/gallery4.jpg') }}" alt="">

            <img src="{{ asset('images/demo/gallery5.jpg') }}" alt="">

            <img src="{{ asset('images/demo/gallery6.jpg') }}" alt="">

        </div>

    </section>


    {{-- =========================
        VIDEO
    ========================== --}}
    <section class="portfolio-video">

        <h2>

            Video Kegiatan

        </h2>

        <div class="video-wrapper">

            <iframe
                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                title="Portfolio Video"
                allowfullscreen>
            </iframe>

        </div>

    </section>


    {{-- =========================
        RELATED
    ========================== --}}
    <section class="related-portfolio">

        <h2>

            Portofolio Lainnya

        </h2>

        <div class="related-grid">

            <div class="related-card">

                <img src="{{ asset('images/demo/portfolio-2.jpg') }}" alt="">

                <h3>

                    Workshop UMKM

                </h3>

                <a href="#">

                    Lihat Detail

                </a>

            </div>

            <div class="related-card">

                <img src="{{ asset('images/demo/portfolio-3.jpg') }}" alt="">

                <h3>

                    Seminar Kepemudaan

                </h3>

                <a href="#">

                    Lihat Detail

                </a>

            </div>

            <div class="related-card">

                <img src="{{ asset('images/demo/portfolio-4.jpg') }}" alt="">

                <h3>

                    Program Rumah Belajar

                </h3>

                <a href="#">

                    Lihat Detail

                </a>

            </div>

        </div>

    </section>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/portfolio-detail.js') }}"></script>
@endpush
