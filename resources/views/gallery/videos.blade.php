@extends('layouts.app')

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

        <input type="hidden" name="per_page" value="{{ request('per_page', 6) }}">

        <div class="galeri-toolbar">

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input id="searchVideo" type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari dokumentasi...">

            </div>

            <div class="sort-box">
                <select id="sortVideo" name="sort">
                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>

                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                        Terlama
                    </option>

                    <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>
                        Judul A-Z
                    </option>

                    <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>
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
                    {{-- Thumbnail Video --}}
                    @php
                        $media = $item->media->where('type', 'video')->first();

                        $thumbnail =
                            $media && $media->youtube_id
                                ? "https://img.youtube.com/vi/{$media->youtube_id}/hqdefault.jpg"
                                : defaultImage('video');
                    @endphp

                    <div class="video-thumbnail">

                        <img src="{{ $thumbnail }}" alt="{{ $item->title }}" loading="lazy"
                            onerror="this.onerror=null; this.src='{{ defaultImage('video') }}';">

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

                    <div class="empty-icon">
                        <i class="fa-solid fa-video"></i>
                    </div>

                    <h2>Belum Ada Galeri Video</h2>

                    <p>
                        Dokumentasi video yang telah dipublikasikan akan muncul di sini.
                        <br>
                        Silakan kembali lagi nanti.
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

                <option value="6" {{ request('per_page', 6) == 6 ? 'selected' : '' }}>
                    6
                </option>

                <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>
                    12
                </option>

                <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>
                    24
                </option>

                <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>
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

            {{-- Nomor Halaman - NOMOR HALAMAN (HANYA 2 ANGKA) --}}
            @php
                $current = $gallery->currentPage();
                $last = $gallery->lastPage();

                $start = $current;
                $end = min($current + 1, $last);

                // Jika di halaman terakhir, mundurkan satu halaman
                if ($start == $last && $last > 1) {
                    $start = $last - 1;
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span class="page-number active">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $gallery->url($page) }}" class="page-number">
                        {{ $page }}
                    </a>
                @endif
            @endfor

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
