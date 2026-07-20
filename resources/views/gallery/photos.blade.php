@extends('layouts.app')

@section('title', 'Galeri Foto')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

<section class="galeri-header">

    <div class="header-text">

        <h1>Galeri Foto</h1>

        <p>
            Dokumentasi seluruh kegiatan Rumah Moeda dalam bentuk foto.
        </p>

    </div>

</section>

<section class="galeri-container">

    @forelse($gallery as $item)

        <a
            href="{{ route('gallery.photos.detail', $item) }}"
            class="galeri-card"
        >

            {{-- Thumbnail --}}
            @if($item->media->isNotEmpty())

                <img
                    loading="lazy"
                    src="{{ asset('storage/'.$item->media->first()->file_path) }}"
                    alt="{{ $item->title }}"
                >

            @endif

            <div class="galeri-info">

                <h3>

                    {{ $item->title }}

                </h3>

                <p>

                    {{ \Illuminate\Support\Str::limit($item->description,100) }}

                </p>

                <div class="galeri-meta">

                    <span>

                        <i class="fa-regular fa-images"></i>

                        {{ $item->media->count() }} Foto

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

            <i class="fa-regular fa-image"></i>

            <h3>Belum ada galeri foto.</h3>

            <p>
                Dokumentasi foto kegiatan belum tersedia.
            </p>

        </div>

    @endforelse

</section>

@endsection
