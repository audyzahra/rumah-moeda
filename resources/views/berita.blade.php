@extends('Layouts.app')

@section('title', 'Berita Rumah Moeda | Informasi Terbaru')

@section('description', 'Dapatkan informasi terbaru seputar kegiatan, program, kolaborasi, dan berbagai aktivitas Rumah Moeda melalui kumpulan berita dan artikel terkini.')

@section('keywords', 'Berita Rumah Moeda, informasi Rumah Moeda, kegiatan Rumah Moeda, program sosial, kolaborasi, dokumentasi kegiatan, artikel Rumah Moeda')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('content')

    <div class="berita-header">

        <div>

            <h1>Berita Rumah Moeda</h1>

            <p>
                Informasi terbaru mengenai kegiatan Rumah Moeda.
            </p>

            <form method="GET" id="filterForm" class="berita-toolbar">

                <div class="search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        name="search"
                        id="searchBerita"
                        placeholder="Cari dokumentasi..."
                        value="{{ request('search') }}">

                </div>

                <div class="sort-box">

                    <select
                        name="sort"
                        id="sortBerita">

                        <option value="terbaru"
                            {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                            Terbaru
                        </option>

                        <option value="terlama"
                            {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                            Terlama
                        </option>

                        <option value="az"
                            {{ request('sort') == 'az' ? 'selected' : '' }}>
                            Judul A-Z
                        </option>

                        <option value="za"
                            {{ request('sort') == 'za' ? 'selected' : '' }}>
                            Judul Z-A
                        </option>

                    </select>

                </div>

                <input
                    type="hidden"
                    name="per_page"
                    value="{{ request('per_page',5) }}">

            </form>
        </div>

    </div>


    <section class="berita-list">

        @forelse($news as $item)
            <div class="berita-card"
                data-title="{{ strtolower($item->title) }}"
                data-content="{{ strtolower(strip_tags($item->content)) }}"
                data-date="{{ \Carbon\Carbon::parse($item->publish_date)->timestamp }}">

                @if ($item->thumbnail)
                    <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}">
                @else
                    <img src="{{ asset('assets/no-image.png') }}" alt="No Image">
                @endif

                <div class="berita-content">

                    <div class="meta">

                        <span>

                            <i class="fa-solid fa-tag"></i>

                            {{ $item->category->name }}

                        </span>

                        <span>

                            <i class="fa-regular fa-calendar"></i>

                            {{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('d F Y') }}

                        </span>

                    </div>

                    <h2>

                        {{ $item->title }}

                    </h2>

                    <p>

                        {{ Str::limit(strip_tags($item->content), 220) }}

                    </p>

                    <div class="action">

                        <a href="{{ route('news.show', $item->slug) }}">

                            Baca Selengkapnya →

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div style="text-align:center;padding:60px;">

                <h3>Belum ada berita.</h3>

            </div>
        @endforelse

    </section>
       {{-- PAGINATION --}}
        <div class="custom-pagination">

    {{-- Show Entries --}}
    <div class="pagination-left">

        <form method="GET">

            @foreach(request()->except('per_page','page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <span>Tampilkan</span>

            <select name="per_page" onchange="this.form.submit()">

                <option value="5" {{ request('per_page',5)==5 ? 'selected' : '' }}>5</option>

                <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>10</option>

                <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>20</option>

                <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>50</option>

            </select>

            <span>berita</span>

        </form>

    </div>

    {{-- Info --}}
    <div class="pagination-center">

        <span>Menampilkan</span>

        <strong>{{ $news->firstItem() ?? 0 }}</strong>

        <span>-</span>

        <strong>{{ $news->lastItem() ?? 0 }}</strong>

        <span>dari</span>

        <strong>{{ $news->total() }}</strong>

        <span>data</span>

    </div>

    {{-- Pagination --}}
    <div class="pagination-right">

        @if ($news->onFirstPage())
            <button class="page-btn" disabled>
                <i class="fa-solid fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $news->previousPageUrl() }}" class="page-btn">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        @foreach ($news->getUrlRange(1,$news->lastPage()) as $page => $url)

            @if ($page == $news->currentPage())

                <span class="page-number active">
                    {{ $page }}
                </span>

            @else

                <a href="{{ $url }}" class="page-number">
                    {{ $page }}
                </a>

            @endif

        @endforeach

        @if ($news->hasMorePages())
            <a href="{{ $news->nextPageUrl() }}" class="page-btn">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled>
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        @endif

    </div>

</div>

    <script>
        const modal = document.getElementById("beritaModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");

        openModal.onclick = function() {
            modal.classList.add("show");
        }

        closeModal.onclick = function() {
            modal.classList.remove("show");
        }

        window.onclick = function(e) {
            if (e.target == modal) {
                modal.classList.remove("show");
            }
        }
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("filterForm");
    const search = document.getElementById("searchBerita");
    const sort = document.getElementById("sortBerita");

    let timer;

    search.addEventListener("keyup", function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            form.submit();
        }, 500);

    });

    sort.addEventListener("change", function () {
        form.submit();
    });

});
</script>

@endsection
