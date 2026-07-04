@extends('Layouts.app')

@section('title', 'Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-image">
            <img src="{{ asset('assets/1.jpeg') }}" alt="Kegiatan Rumah Moeda">
        </div>

        <div class="hero-text">
            <p>
                Bukan hanya tentang menikmati pertunjukan, tetapi juga tentang
                menghadirkan kemudahan. Rumah Moeda bersama OganLopian
                mendukung transformasi digital sektor pariwisata Purwakarta.
            </p>
        </div>
    </div>
</section>

<!-- Visi Misi -->
<section class="visi-misi-section">

    <h2 class="section-title">Visi & Misi</h2>

    <div class="visi-misi-container">

        <div class="visi-box">
            <h3>Visi</h3>

            <p>
                "MUDA OBSERVATF ENERJIK DINAMIS AKTIF."
            </p>
        </div>

        <div class="misi-box">

            <h3>Misi</h3>

            <ol>
                <li>
                    Mengembangkan potensi generasi muda agar menjadi pribadi
                    yang kreatif, inovatif, dan berdaya saing melalui pendidikan,
                    pelatihan, serta kegiatan yang bermanfaat.
                </li>

                <li>
                    Membangun budaya yang observatif, dinamis, dan adaptif
                    dalam menghadapi perkembangan zaman dengan mengedepankan
                    kolaborasi, pembelajaran, dan inovasi.
                </li>

                <li>
                    Mendorong partisipasi aktif masyarakat, khususnya generasi muda,
                    dalam menciptakan kegiatan sosial, pendidikan, dan pemberdayaan
                    yang memberikan dampak positif bagi lingkungan.
                </li>

            </ol>

        </div>

    </div>

</section>

<!-- Struktur Organisasi -->
<section class="struktur-section">

    <h2 class="section-title">
        Struktur Organisasi
    </h2>

    <p class="section-subtitle">
        Sinergi para profesional untuk impak sosial yang nyata.
    </p>

    <div class="tree-container">

        <div class="tree-row row-top">

            <div class="member-card">

                <img
                    src="{{ asset('assets/logorumahmoeda.png') }}"
                    class="avatar"
                    alt="Ketua">

                <h4>Dr. Hermawan</h4>

                <p>Ketua Yayasan</p>

            </div>

        </div>

        <div class="tree-row row-bottom">

            <div class="member-card">

                <img
                    src="{{ asset('assets/logorumahmoeda.png') }}"
                    class="avatar"
                    alt="Sekretaris">

                <h4>Dr. Hermawan</h4>

                <p>Sekretaris</p>

            </div>

            <div class="member-card">

                <img
                    src="{{ asset('assets/2.jpg') }}"
                    class="avatar"
                    alt="Bendahara">

                <h4>Dr. Hermawan</h4>

                <p>Bendahara</p>

            </div>

            <div class="member-card">

                <img
                    src="{{ asset('assets/logorumahmoeda.png') }}"
                    class="avatar"
                    alt="Divisi Program">

                <h4>Dr. Hermawan</h4>

                <p>Divisi Program</p>

            </div>

        </div>

    </div>

</section>

<!-- Artikel -->
<section class="artikel-section">

    <h2 class="section-title text-left">
        Artikel
    </h2>

    <p class="section-subtitle text-left">
        Inspirasi dan kabar terkini dari lapangan.
    </p>

    <div class="artikel-grid">

        <!-- Artikel 1 -->
        <div class="artikel-card">

            <div class="card-img-wrapper">
                <img src="{{ asset('assets/artikel/1.jpeg') }}">
            </div>

            <div class="card-content">

                <span class="category">
                    Pemberdayaan
                </span>

                <h3>
                    Digitalisasi UMKM Desa Melalui Inisiatif Heritage Pulse
                </h3>

                <p>
                    Langkah awal kami dalam membawa produk lokal menuju pasar global
                    dengan sentuhan digital.
                </p>

                <div class="card-date">
                    <i class="far fa-calendar"></i>
                    03 July 2026
                </div>

            </div>

        </div>

        <!-- Artikel 2 -->
        <div class="artikel-card">

            <div class="card-img-wrapper">
                <img src="{{ asset('assets/artikel/2.jpg') }}">
            </div>

            <div class="card-content">

                <span class="category">
                    Kebudayaan
                </span>

                <h3>
                    Menjaga Warisan: Restorasi Digital Arsip Keraton
                </h3>

                <p>
                    Proyek kolaborasi Rumah Moeda dalam mengamankan dokumen
                    bersejarah.
                </p>

                <div class="card-date">
                    <i class="far fa-calendar"></i>
                    03 Maret 2026
                </div>

            </div>

        </div>

        <!-- Artikel 3 -->
        <div class="artikel-card">

            <div class="card-img-wrapper">
                <img src="{{ asset('assets/artikel/3.jpg') }}">
            </div>

            <div class="card-content">

                <span class="category">
                    Edukasi
                </span>

                <h3>
                    Kurikulum Kreatif Rumah Moeda: Beasiswa 2024
                </h3>

                <p>
                    Membuka pendaftaran bagi 100 talents muda untuk bergabung
                    dalam program akselerasi.
                </p>

                <div class="card-date">
                    <i class="far fa-calendar"></i>
                    21 April 2026
                </div>

            </div>

        </div>

    </div>

</section>

<!-- Dokumentasi -->
<section class="dokumentasi-section">

    <div class="container">

        <h2 class="section-title">
            Dokumentasi Aktivitas
        </h2>

        <p class="section-subtitle">
            Momen kebersamaan dalam setiap langkah perubahan.
        </p>

        <div class="gallery-grid">

            <div class="gallery-item gallery-large">
                <img src="{{ asset('assets/dokumentasi/1.jpg') }}">
            </div>

            <div class="gallery-item">
                <img src="{{ asset('assets/dokumentasi/1.jpg') }}">
            </div>

            <div class="gallery-item">
                <img src="{{ asset('assets/dokumentasi/1.jpg') }}">
            </div>

            <div class="gallery-item">
                <img src="{{ asset('assets/dokumentasi/1.jpg') }}">
            </div>

            <div class="gallery-item">
                <img src="{{ asset('assets/dokumentasi/1.jpg') }}">
            </div>

        </div>

    </div>

</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">

    <span class="close">&times;</span>

    <img
        class="lightbox-img"
        id="lightbox-img">

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
