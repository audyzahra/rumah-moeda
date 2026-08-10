@extends('layouts.app')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
    @endpush

@section('content')

    <div class="video-detail-page">

        <section class="video-detail-header">

            <div class="video-detail-container">

                <a href="{{ route('gallery.videos') }}" class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Galeri Video</span>
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
            $hero = $gallery->media->first();
        @endphp

        @if ($hero)

            <section class="hero-video">

                <div class="video-detail-container">

                    @if ($hero->video_url)
                        <iframe class="hero-player" src="https://www.youtube.com/embed/{{ $hero->youtube_id }}"
                            title="{{ $gallery->title }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    @else
                        <video class="hero-player" controls preload="metadata">

                            <source src="{{ Storage::url($hero->file_path) }}" type="video/mp4">

                            Browser Anda tidak mendukung video.

                        </video>
                    @endif

                </div>

            </section>
        @else
            <section class="hero-video">

                <div class="video-detail-container">

                    <img class="hero-player" src="{{ defaultImage('video') }}" alt="Video Default">

                </div>

            </section>

        @endif

        {{-- Video lainnya (jika ada) --}}
        @if ($gallery->media->count() > 1)

            <section class="video-detail-section">

                <div class="video-detail-container">

                    <div class="video-grid">

                        @foreach ($gallery->media->skip(1) as $media)
                            <div class="video-card">

                                @if ($media->video_url)
                                    <iframe src="https://www.youtube.com/embed/{{ $media->youtube_id }}"
                                        title="{{ $gallery->title }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    <video controls preload="metadata">

                                        <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">

                                        Browser Anda tidak mendukung video.

                                    </video>
                                @endif

                            </div>
                        @endforeach

                    </div>

                </div>

            </section>

        @endif


        {{-- Deskripsi --}}
        @if ($gallery->description)
            <section class="gallery-description">

                <div class="video-detail-container">

                    <div class="deskripsi">

                        {!! $gallery->description !!}

                    </div>

                </div>

            </section>
        @endif

    </div>

@endsection
