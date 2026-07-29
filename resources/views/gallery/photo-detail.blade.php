@extends('layouts.app')

@section('title', $gallery->title)

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

                @if ($gallery->activity_date)
                    <p class="tanggal">
                        <i class="fa-regular fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($gallery->activity_date)->translatedFormat('d F Y') }}
                    </p>
                @endif

            </div>

        </section>

        @php
            $hero = $gallery->media->first();
        @endphp

        @if ($hero)
            <section class="hero-photo">

                <div class="photo-detail-container">

                    <img src="{{ asset('storage/' . $hero->file_path) }}" alt="{{ $gallery->title }}"
                        class="hero-image preview-image">

                </div>

            </section>
        @endif


        @if ($gallery->media->count() > 1)

            <section class="photo-detail-section">

                <div class="photo-detail-container">

                    <div class="photo-grid">

                        @foreach ($gallery->media->skip(1) as $media)
                            <div class="photo-card">

                                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $gallery->title }}"
                                    loading="lazy" class="preview-image">

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
