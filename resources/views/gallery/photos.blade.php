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

            <input type="text" id="searchGaleri" placeholder="Cari dokumentasi...">
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
            <a href="{{ route('gallery.photos.detail', $item) }}" class="galeri-card"
                data-title="{{ strtolower($item->title) }}"
                data-description="{{ strtolower(strip_tags($item->description)) }}"
                data-date="{{ \Carbon\Carbon::parse($item->activity_date)->timestamp }}">

                {{-- Thumbnail --}}
                @if ($item->media->isNotEmpty())
                    <img loading="lazy" src="{{ asset('storage/' . $item->media->first()->file_path) }}"
                        alt="{{ $item->title }}">
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

        {{-- Show Entries --}}
        <div class="pagination-left">

            <form method="GET" id="perPageForm">

                {{-- Menyimpan query search/sort jika nanti ada --}}
                @foreach (request()->except('per_page', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <span>Tampilkan</span>

                <select name="per_page" onchange="this.form.submit()">

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

                <span>galeri</span>

            </form>

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
