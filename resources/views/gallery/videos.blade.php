@extends('layouts.app')

@section('title', 'Galeri Video | Rumah Moeda')

@section('description', 'Saksikan berbagai dokumentasi video kegiatan, program, kolaborasi, dan aktivitas Rumah Moeda bersama masyarakat serta mitra.')

@section('keywords', 'Galeri Video Rumah Moeda, video kegiatan Rumah Moeda, dokumentasi video, program sosial, kolaborasi, mitra, kegiatan Rumah Moeda')

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

    <form method="GET" id="galleryFilter">

        <input
            type="hidden"
            name="per_page"
            value="{{ request('per_page', 6) }}">

        <div class="galeri-toolbar">

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    id="searchVideo"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari dokumentasi...">

            </div>

            <div class="sort-box">
                <select id="sortVideo" name="sort">
                    <option
                        value="terbaru"
                        {{ request('sort','terbaru') == 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>

                    <option
                        value="terlama"
                        {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                        Terlama
                    </option>

                    <option
                        value="az"
                        {{ request('sort') == 'az' ? 'selected' : '' }}>
                        Judul A-Z
                    </option>

                    <option
                        value="za"
                        {{ request('sort') == 'za' ? 'selected' : '' }}>
                        Judul Z-A
                    </option>
                </select>
            </div>
        </div>
    </form>

    <div id="galleryTable">
        <section class="galeri-container">

            @forelse($gallery as $item)
                <a href="{{ route('gallery.videos.detail', $item) }}" class="galeri-card"
                    data-title="{{ strtolower($item->title) }}"
                    data-description="{{ strtolower(strip_tags($item->description)) }}"
                    data-date="{{ \Carbon\Carbon::parse($item->activity_date)->timestamp }}">

                    {{-- Thumbnail Video --}}
                    @php
                        $media = $item->media->first();

                        if ($media && $media->youtube_id) {
                            $thumbnail = "https://img.youtube.com/vi/{$media->youtube_id}/hqdefault.jpg";
                        } else {
                            $thumbnail = defaultImage('video');
                        }
                    @endphp

                    <div class="video-thumbnail">

                        <img src="{{ $thumbnail }}" alt="{{ $item->title }}" loading="lazy">

                        <div class="play-icon">

                            <i class="fa-solid fa-circle-play"></i>

                        </div>

                    </div>


                    <div class="galeri-info">

                        <h3>
                            {{ $item->title }}
                        </h3>

                        <p>
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 100) }}
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

                    <h3>
                        Belum ada galeri video.
                    </h3>

                    <p>
                        Dokumentasi video kegiatan belum tersedia.
                    </p>

                </div>
            @endforelse

        </section>
    </div>

    {{-- PAGINATION --}}
    <div class="custom-pagination">

        {{-- Show Entries --}}
        <div class="pagination-left">

            <span>Tampilkan</span>

                <select id="perPageSelect" form="galleryFilter" name="per_page">

                    <option value="6" {{ request('per_page',6)==6 ? 'selected' : '' }}>
                        6
                    </option>

                    <option value="12" {{ request('per_page')==12 ? 'selected' : '' }}>
                        12
                    </option>

                    <option value="24" {{ request('per_page')==24 ? 'selected' : '' }}>
                        24
                    </option>

                    <option value="48" {{ request('per_page')==48 ? 'selected' : '' }}>
                        48
                    </option>

                </select>

            <span>video</span>

        </div>

        {{-- Info --}}
        <div class="pagination-center">

            <span>Menampilkan</span>

            <strong>{{ $gallery->firstItem() ?? 0 }}</strong>

            <span>-</span>

            <strong>{{ $gallery->lastItem() ?? 0 }}</strong>

            <span>dari</span>

            <strong>{{ $gallery->total() }}</strong>

            <span>data</span>

        </div>

        {{-- Pagination --}}
        <div class="pagination-right">

            {{-- Previous --}}
            @if ($gallery->onFirstPage())
                <button class="page-btn" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            @else
                <a href="{{ $gallery->previousPageUrl() }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($gallery->getUrlRange(1, $gallery->lastPage()) as $page => $url)
                @if ($page == $gallery->currentPage())
                    <span class="page-number active">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="page-number">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($gallery->hasMorePages())
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
