    @extends('layouts.app')

    @section('title', $gallery->title)

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
    @endpush

    @section('content')

        <section class="galeri-detail-header">

            <div class="container">

                <a href="{{ route('gallery.videos') }}" class="back-button">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali ke Galeri Video

                </a>

                <h1>{{ $gallery->title }}</h1>

                @if ($gallery->activity_date)
                    <p class="tanggal">

                        <i class="fa-regular fa-calendar"></i>

                        {{ \Carbon\Carbon::parse($gallery->activity_date)->translatedFormat('d F Y') }}

                    </p>
                @endif

                @if ($gallery->description)
                    <p class="deskripsi">

                        {{ $gallery->description }}

                    </p>
                @endif

            </div>

        </section>

        <section class="video-detail-section">

            <div class="video-grid">

                @forelse($gallery->media as $media)
                    <div class="video-card">

                        @if ($media->youtube_id)
                            <div class="youtube-wrapper">

                                <iframe src="https://www.youtube.com/embed/{{ $media->youtube_id }}"
                                    title="{{ $gallery->title }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>

                            </div>
                        @endif

                    </div>

                @empty

                    <div class="empty-gallery">

                        <i class="fa-solid fa-video-slash"></i>

                        <h3>Tidak ada video.</h3>

                    </div>
                @endforelse

            </div>

        </section>

    @endsection
