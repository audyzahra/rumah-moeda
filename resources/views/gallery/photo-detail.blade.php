@extends('layouts.app')

@section('title', $gallery->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

<section class="galeri-detail-header">

    <div class="container">

        <a href="{{ route('gallery.photos') }}" class="back-button">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Galeri Foto
        </a>

        <h1>{{ $gallery->title }}</h1>

        @if($gallery->activity_date)
            <p class="tanggal">
                <i class="fa-regular fa-calendar"></i>
                {{ \Carbon\Carbon::parse($gallery->activity_date)->translatedFormat('d F Y') }}
            </p>
        @endif

        @if($gallery->description)
            <p class="deskripsi">
                {{ $gallery->description }}
            </p>
        @endif

    </div>

</section>

<section class="photo-detail-section">

    <div class="photo-grid">

        @forelse($gallery->media as $media)

            <a
                href="{{ asset('storage/'.$media->file_path) }}"
                target="_blank"
                class="photo-card"
            >

                <img
                    src="{{ asset('storage/'.$media->file_path) }}"
                    alt="{{ $gallery->title }}"
                    loading="lazy"
                >

            </a>

        @empty

            <div class="empty-gallery">

                <i class="fa-regular fa-image"></i>

                <h3>Tidak ada foto.</h3>

            </div>

        @endforelse

    </div>

</section>

@endsection
