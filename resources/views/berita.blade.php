@extends('Layouts.app')

@section('title', 'Berita')

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

            <div class="berita-toolbar">

    <div class="search-box">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            id="searchBerita"
            placeholder="Cari dokumentasi..."
        >

    </div>

    <div class="sort-box">

        <select id="sortBerita">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
            <option value="az">Judul A-Z</option>
            <option value="za">Judul Z-A</option>
        </select>

    </div>

</div>
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
   
<div class="custom-pagination">

    <div class="pagination-info">
        Menampilkan 1 - 10 dari 10 data
    </div>

    <div class="pagination-page">

        <button class="page-btn" disabled>
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <span>Halaman 1 dari 2</span>

        <button class="page-btn">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

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

    const searchInput = document.getElementById("searchBerita");
    const sortSelect = document.getElementById("sortBerita");
    const beritaList = document.querySelector(".berita-list");

    function filterAndSort() {

        const keyword = searchInput.value.toLowerCase().trim();

        let cards = Array.from(document.querySelectorAll(".berita-card"));

        // SEARCH
        cards.forEach(function(card) {

            const title = card.dataset.title;
            const content = card.dataset.content;

            if (title.includes(keyword) || content.includes(keyword)) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }

        });

        // SORT
        cards.sort(function(a, b) {

            switch (sortSelect.value) {

                case "terbaru":
                    return Number(b.dataset.date) - Number(a.dataset.date);

                case "terlama":
                    return Number(a.dataset.date) - Number(b.dataset.date);

                case "az":
                    return a.dataset.title.localeCompare(b.dataset.title);

                case "za":
                    return b.dataset.title.localeCompare(a.dataset.title);

                default:
                    return 0;
            }

        });

        cards.forEach(function(card) {
            beritaList.appendChild(card);
        });

    }

    searchInput.addEventListener("keyup", filterAndSort);
    sortSelect.addEventListener("change", filterAndSort);

});
</script>

@endsection
