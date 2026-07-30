@extends('Layouts.app')

@section('title', 'Galeri')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

    <section class="galeri-header">

        <div class="header-text">

            <h1>Galeri Kegiatan</h1>

            <p>
                Dokumentasi berbagai kegiatan Rumah Moeda.
            </p>

        </div>

    </section>


    <section class="galeri-container">

        @forelse($gallery as $item)
            @php
                $media = $item->media->first();

                if (!$media) {
                    $thumbnail = asset('assets/images/foto-default.jpg');
                } elseif ($media->type === 'video') {
                    $thumbnail = asset('assets/images/video-default.jpg');
                } else {
                    $thumbnail = Storage::url($media->file_path);
                }
            @endphp

            <a href="{{ route('gallery.photo.detail', $item->id) }}" class="galeri-card">

                <img loading="lazy" src="{{ $thumbnail }}" alt="{{ $item->title }}">

                <div class="galeri-info">

                    <h3>
                        {{ $item->title }}
                    </h3>

                    <p>
                        {{ Str::limit($item->description, 80) }}
                    </p>

                    <span>
                        <i class="fa-regular fa-calendar"></i>

                        {{ \Carbon\Carbon::parse($item->activity_date)->translatedFormat('d F Y') }}
                    </span>

                </div>

            </a>

        @empty

            <div style="grid-column:1/-1;text-align:center;padding:60px">

                <h3>
                    Belum ada dokumentasi kegiatan.
                </h3>

            </div>
        @endforelse

    </section>

@endsection
