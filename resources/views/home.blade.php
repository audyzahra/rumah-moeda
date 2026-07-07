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

                @if ($setting && $setting->hero_image)
                    <img src="{{ asset($setting->hero_image) }}" alt="{{ $setting->website_name }}">
                @else
                    <img src="{{ asset('assets/hero/default.jpg') }}" alt="Hero">
                @endif

            </div>

            <div class="hero-text">
                <div class="hero-content">

                    <span class="hero-line"></span>

                    <h1>
                        Rumah <span>Moeda</span>
                    </h1>

                    <p>
                        {{ $setting->website_description }}
                    </p>

                </div>
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
                    "{{ $vision->vision }}"
                </p>

            </div>

            <div class="misi-box">

                <h3>Misi</h3>

                <ol>

                    @foreach ($vision->missions as $mission)
                        <li>
                            {{ $mission->mission }}
                        </li>
                    @endforeach

                </ol>

            </div>

        </div>

    </section>

    <!-- Struktur Organisasi -->
    <section class="struktur-section">

        <h2 class="section-title">Struktur Organisasi</h2>

        <p class="section-subtitle">
            Tim yang berkomitmen membangun Rumah Moeda dengan semangat kolaborasi.
        </p>


        {{-- Ketua --}}
        @foreach ($organizations->where('display_order', 1) as $member)

            <div class="leader-card">

                <img 
                    src="{{ asset('storage/' . $member->photo) }}" 
                    alt="{{ $member->full_name }}">

                <h3>{{ $member->full_name }}</h3>

                <span>{{ $member->position }}</span>

            </div>

        @endforeach


        {{-- Anggota --}}
        <div class="team-grid">

            @foreach ($organizations->where('display_order', '>', 1) as $member)

                <div class="team-card">

                    <img 
                        src="{{ asset('storage/' . $member->photo) }}" 
                        alt="{{ $member->full_name }}">

                    <h4>{{ $member->full_name }}</h4>

                    <p>{{ $member->position }}</p>

                </div>

            @endforeach

        </div>

    </section>

    <!-- Artikel -->
    <section class="artikel-section">

        <h2 class="section-title text-left">
            Berita
        </h2>

        <p class="section-subtitle text-left">
            Inspirasi dan kabar terkini dari lapangan.
        </p>

        <div class="artikel-grid">

            @foreach ($news as $article)
                <div class="artikel-card">

                    <div class="card-img-wrapper">
                        <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}">
                    </div>

                    <div class="card-content">

                        <span class="category">
                            {{ $article->category->name }}
                        </span>

                        <h3>
                            {{ $article->title }}
                        </h3>

                        <p>
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100) }}
                        </p>

                        <div class="card-date">
                            <i class="far fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($article->publish_date)->translatedFormat('d F Y') }}
                        </div>

                    </div>

                </div>
            @endforeach

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

                @foreach ($documentations as $documentation)
                    <div class="gallery-item {{ $loop->first ? 'gallery-large' : '' }}">
                        <img src="{{ asset($documentation->photo) }}" alt="{{ $documentation->title }}">
                    </div>
                @endforeach

            </div>

        </div>

    </section>
    <!-- ================= MITRA ================= -->

    <section class="mitra-section">

        <div class="container">

            <h2 class="section-title">
                Mitra Kami
            </h2>

            <p class="section-subtitle">
                Bersama para mitra kami menghadirkan dampak yang lebih luas bagi masyarakat.
            </p>

            <div class="mitra-slider">

                <div class="mitra-track">

                    {{-- Loop Pertama --}}

                    @foreach ($partners as $partner)
                        @if ($partner->website)
                            <a href="{{ $partner->website }}" target="_blank" class="mitra-item">

                                <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}"
                                    title="{{ $partner->name }}">

                            </a>
                        @else
                            <div class="mitra-item">

                                <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}"
                                    title="{{ $partner->name }}">

                            </div>
                        @endif
                    @endforeach


                    {{-- Duplicate supaya animasi tidak putus --}}

                    @foreach ($partners as $partner)
                        @if ($partner->website)
                            <a href="{{ $partner->website }}" target="_blank" class="mitra-item">

                                <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}"
                                    title="{{ $partner->name }}">

                            </a>
                        @else
                            <div class="mitra-item">

                                <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}"
                                    title="{{ $partner->name }}">

                            </div>
                        @endif
                    @endforeach

                </div>

            </div>

        </div>

    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">

        <span class="close">&times;</span>

        <img class="lightbox-img" id="lightbox-img">

    </div>

@endsection
