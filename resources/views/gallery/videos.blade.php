@extends('layouts.app')

@section('title', 'Galeri Video')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

    <section class="galeri-header">

        <div class="header-text">

            <h1>Galeri Video</h1>

            <p>
                Dokumentasi seluruh kegiatan Rumah Moeda dalam bentuk video.
            </p>

        </div>

    </section>

    <section class="galeri-container">

        @forelse($gallery as $item)

            <a href="{{ route('gallery.videos.detail', $item) }}" class="galeri-card">

                {{-- Thumbnail Video --}}
                @if ($item->media->isNotEmpty())
                    <div class="video-thumbnail">

                        @if ($item->media->first()->youtube_id)
                            <div class="video-thumbnail">

                                <img src="https://img.youtube.com/vi/{{ $item->media->first()->youtube_id }}/hqdefault.jpg"
                                    alt="{{ $item->title }}">

                                <div class="play-icon">
                                    <i class="fa-solid fa-circle-play"></i>
                                </div>

                            </div>
                        @endif

                        <div class="play-icon">

                            <i class="fa-solid fa-circle-play"></i>

                        </div>

                    </div>
                @endif

                <div class="galeri-info">

                    <h3>

                        {{ $item->title }}

                    </h3>

                    <p>

                        {{ \Illuminate\Support\Str::limit($item->description, 100) }}

                    </p>

                    <div class="galeri-meta">

                        <span>

                            <i class="fa-solid fa-video"></i>

                            {{ $item->media->count() }} Video

                        </span>

                        <span>

                            <i class="fa-regular fa-calendar"></i>

                            {{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d F Y') }}

                        </span>

                    </div>

                </div>

            </a>

        @empty

            <div class="empty-gallery">

                <i class="fa-solid fa-video-slash"></i>

                <h3>Belum ada galeri video.</h3>

                <p>
                    Dokumentasi video kegiatan belum tersedia.
                </p>

            </div>

        @endforelse

    </section>

@endsection
