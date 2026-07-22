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
            <img src="{{ Storage::url($setting->hero_image) }}" alt="{{ $setting->website_name }}">
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

    <div class="organization-wrapper">

        <div id="organization-chart"></div>

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
                @if ($article->thumbnail)
                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}">
                @else
                <img src="{{ asset('assets/no-image.png') }}" alt="No Image">
                @endif
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

<!-- Gallery -->
<section class="dokumentasi-section">

    <div class="container">

        <h2 class="section-title">
            Dokumentasi Aktivitas
        </h2>

        <p class="section-subtitle">
            Momen kebersamaan dalam setiap langkah perubahan.
        </p>

        <div class="gallery-wrapper">

            {{-- Video --}}
            <div class="gallery-video">

                @if($videos->isNotEmpty())

                @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&\n?#]+)/', $videos->first()->video_url, $matches);
                $youtubeId = $matches[1] ?? '';
                @endphp

                <a
                    href="javascript:void(0)"
                    onclick="openVideo('{{ $videos->first()->youtube_id }}')">

                    <img
                        src="https://img.youtube.com/vi/{{ $videos->first()->youtube_id }}/maxresdefault.jpg">

                    <div class="overlay">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>

                </a>

                @endif

            </div>

            {{-- Foto --}}
            <div class="gallery-photo-grid">

                @foreach($photos as $photo)

                <div
                    class="photo-item"
                    data-image="{{ asset('storage/'.$photo->file_path) }}"
                    onclick="openImage(this)">

                    <img
                        src="{{ asset('storage/'.$photo->file_path) }}"
                        alt="Foto">

                    <div class="overlay">
                        <i class="fa-solid fa-expand"></i>
                    </div>

                </div>
                @endforeach

            </div>

        </div>
    </div>

</section>

<!-- galery modal -->
<div id="galleryModal" class="gallery-modal">

    <span class="close-modal">&times;</span>

    <div id="modalContent"></div>

</div>


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

                    @if ($partner->logo)
                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                        title="{{ $partner->name }}">
                    @else
                    <img src="{{ asset('assets/no-image.png') }}" alt="{{ $partner->name }}">
                    @endif

                </a>
                @else
                <div class="mitra-item">

                    @if ($partner->logo)
                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                        title="{{ $partner->name }}">
                    @else
                    <img src="{{ asset('assets/no-image.png') }}" alt="{{ $partner->name }}">
                    @endif

                </div>
                @endif
                @endforeach


                {{-- Duplicate supaya animasi tidak putus --}}

                @foreach ($partners as $partner)
                @if ($partner->website)
                <a href="{{ $partner->website }}" target="_blank" class="mitra-item">

                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
                        title="{{ $partner->name }}">

                </a>
                @else
                <div class="mitra-item">

                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}"
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

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endpush

<!-- untuk google chart -->
@push('scripts')

<script src="https://www.gstatic.com/charts/loader.js"></script>

<script id="organization-data" type="application/json">
@json($organizations)
</script>

<script src="{{ asset('js/organization-chart.js') }}"></script>

<script src="{{ asset('js/home.js') }}"></script>

@endpush