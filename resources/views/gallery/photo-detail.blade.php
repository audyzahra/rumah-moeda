@extends('layouts.app')


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

    <div class="photo-detail-page">

        <section class="galeri-detail-header">

            <div class="photo-detail-container">

                <a href="{{ route('gallery.photos') }}" class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Galeri Foto</span>
                </a>

                <h1>{{ $gallery->title }}</h1>

                <div class="galeri-meta">

                    @if ($gallery->activity_date)
                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($gallery->activity_date)->translatedFormat('d F Y') }}
                        </span>
                    @endif

                    <span>
                        <i class="fa-regular fa-user"></i>
                        {{ $gallery->author->name ?? 'Admin Rumah Moeda' }}
                    </span>

                    <span>
                        <i class="fa-regular fa-eye"></i>
                        {{ number_format($gallery->views ?? 0) }}
                    </span>

                </div>

            </div>

        </section>

        @php
    $images = $gallery->media->where('type', 'image');
    $hero = $images->first();
@endphp

<section class="hero-photo">
    <div class="photo-detail-container">
        @php
            $heroImage = ($hero && $hero->file_path && Storage::disk('public')->exists($hero->file_path))
                ? Storage::disk('public')->url($hero->file_path)
                : defaultImage();
        @endphp

        <img
            src="{{ $heroImage }}"
            alt="{{ $gallery->title }}"
            class="hero-image preview-image"
        >
    </div>
</section>

@if ($images->count() > 1)
    <section class="photo-detail-section">
        <div class="photo-detail-container">
            <div class="photo-grid">

                @foreach ($images->skip(1) as $media)
                    @php
                        $image = ($media->file_path && Storage::disk('public')->exists($media->file_path))
                            ? Storage::disk('public')->url($media->file_path)
                            : defaultImage();
                    @endphp

                    <div class="photo-card">
                        <img
                            src="{{ $image }}"
                            alt="{{ $gallery->title }}"
                            loading="lazy"
                            class="preview-image"
                        >
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endif

        @if ($gallery->description)
            <section class="gallery-description">

                <div class="photo-detail-container">

                    <div class="deskripsi">

                        {!! $gallery->description !!}

                    </div>

                </div>

            </section>
        @endif

    </div>
    <div class="lightbox" id="lightbox">

        <span class="lightbox-close">
            <i class="fa-solid fa-xmark"></i>
        </span>

        <img id="lightboxImage" src="" alt="Preview">

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/gallery-detail.js') }}"></script>
@endpush
