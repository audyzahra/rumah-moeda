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

<div class="galeri-toolbar">

    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            id="searchGaleri"
            placeholder="Cari dokumentasi..."
        >
    </div>

    <div class="sort-box">
        <select id="sortGaleri">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
            <option value="az">Judul A-Z</option>
            <option value="za">Judul Z-A</option>
        </select>
    </div>

</div>

<section class="galeri-container">

    @forelse($gallery as $item)

        <a
    href="{{ route('gallery.photos.detail', $item) }}"
    class="galeri-card"
    data-title="{{ strtolower($item->title) }}"
    data-description="{{ strtolower(strip_tags($item->description)) }}"
    data-date="{{ \Carbon\Carbon::parse($item->activity_date)->timestamp }}"
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

                    {{ Str::limit(strip_tags($item->description), 100) }}       

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
        {{-- PAGINATION --}}
        <div class="custom-pagination">

            <div class="pagination-info">

                Menampilkan

                <strong>{{ $gallery->firstItem() ?? 0 }}</strong>

                -

                <strong>{{ $gallery->lastItem() ?? 0 }}</strong>

                dari

                <strong>{{ $gallery->total() }}</strong>

                data

            </div>

            <div class="pagination-page">

                {{-- Previous --}}
                @if($gallery->onFirstPage())

                    <button class="page-btn" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                @else

                    <a href="{{ $gallery->previousPageUrl() }}" class="page-btn">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                @endif

                <span>

                    Halaman

                    {{ $gallery->currentPage() }}

                    dari

                    {{ $gallery->lastPage() }}

                </span>

                {{-- Next --}}
                @if($gallery->hasMorePages())

                    <a href="{{ $gallery->nextPageUrl() }}" class="page-btn">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>

                @else

                    <button class="page-btn" disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                @endif

            </div>

        </div>
@push('scripts')
    <script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush
@endsection
