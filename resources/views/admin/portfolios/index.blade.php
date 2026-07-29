@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/index.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
@endpush

@section('content')

<div class="portfolio-page">

    <!-- ================= HEADER ================= -->
    <div class="portfolio-header">

        <div class="portfolio-header-info">

            <h1 class="portfolio-title">
                Portfolio
            </h1>

            <p class="portfolio-subtitle">
                Daftar kerja sama dan kegiatan perusahaan
            </p>

        </div>

        <a href="{{ route('admin.portfolios.create') }}"
            class="portfolio-btn-add">

            <i class="fa-solid fa-plus"></i>

            <span>Tambah Portfolio</span>

        </a>

    </div>



    <!-- ================= FILTER ================= -->

    <form id="portfolioFilter"
        method="GET"
        action="{{ route('admin.portfolios.index') }}"
        class="portfolio-filter">

        <div class="row g-3">

            <div class="col-md-6">

                <input
                    type="text"
                    id="searchPortfolio"
                    name="search"
                    class="form-control"
                    placeholder="Cari judul, kategori, mitra, author..."
                    value="{{ request('search') }}">

            </div>


            <div class="col-md-3">

                <select
                    id="sortPortfolio"
                    name="sort"
                    class="form-control">

                    <option value="">
                        Terbaru
                    </option>

                    <option value="oldest"
                        {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        Terlama
                    </option>

                    <option value="title_asc"
                        {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                        Judul A-Z
                    </option>

                    <option value="title_desc"
                        {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                        Judul Z-A
                    </option>

                </select>

            </div>


            <div class="col-md-3 d-grid">

                <a href="{{ route('admin.portfolios.index') }}"
                    class="portfolio-btn-reset">

                    Reset

                </a>

            </div>

        </div>

    </form>



    <!-- ================= TABLE ================= -->

    <div class="portfolio-card">

        <div class="portfolio-table-wrapper">

            <table class="portfolio-table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Mitra</th>
                        <th>Media</th>
                        <th>Author</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody id="portfolioTable">

                    @if ($portfolios->count())

                        @foreach ($portfolios as $portfolio)

                            <tr
                                data-title="{{ strtolower($portfolio->title) }}"
                                data-category="{{ strtolower($portfolio->category->name ?? '') }}"
                                data-partner="{{ strtolower($portfolio->partner->name ?? '') }}"
                                data-author="{{ strtolower($portfolio->author->name ?? '') }}">

                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <td>

                                    {{ $portfolio->title }}

                                </td>


                                <td>

                                    {{ $portfolio->category->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $portfolio->partner->name ?? '-' }}

                                </td>


                                <td>

                                    @if ($portfolio->media->count())

                                        <span class="portfolio-badge portfolio-badge-success">

                                            {{ $portfolio->media->count() }} Media

                                        </span>

                                    @else

                                        <span class="portfolio-badge portfolio-badge-secondary">

                                            Tidak Ada

                                        </span>

                                    @endif

                                </td>


                                <td>

                                    {{ $portfolio->author->name ?? '-' }}

                                </td>


                                <td>

                                    {!! Str::limit(strip_tags($portfolio->description), 80) !!}

                                </td>


                                <td>

                                    {{ date('d M Y', strtotime($portfolio->activity_date)) }}

                                </td>


                                <td>

                                    <div class="portfolio-action-buttons">

                                        <!-- DETAIL -->

                                        <button
                                            type="button"
                                            class="portfolio-btn-detail btn-detail"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailPortfolioModal"
                                            data-title="{{ $portfolio->title }}"
                                            data-category="{{ $portfolio->category->name ?? '-' }}"
                                            data-partner="{{ $portfolio->partner->name ?? '-' }}"
                                            data-date="{{ date('d M Y', strtotime($portfolio->activity_date)) }}"
                                            data-location="{{ $portfolio->location ?? '-' }}"
                                            data-lat="{{ $portfolio->latitude }}"
                                            data-lng="{{ $portfolio->longitude }}"
                                            data-participants="{{ $portfolio->participants ?? 0 }}"
                                            data-author="{{ $portfolio->author->name ?? '-' }}"
                                            data-description='@json($portfolio->description)'
                                            data-media='@json($portfolio->media)'>

                                            <i class="fa-solid fa-eye"></i>

                                        </button>


                                        <!-- EDIT -->

                                        <a
                                            href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                            class="portfolio-btn-edit">

                                            <i class="fa-solid fa-pen-to-square"></i>

                                        </a>


                                        <!-- DELETE -->

                                        <form
                                            action="{{ route('admin.portfolios.destroy', $portfolio->id) }}"
                                            method="POST"
                                            class="d-inline delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="portfolio-btn-delete">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="9" class="portfolio-empty">

                                Data portfolio tidak ditemukan

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

        <!-- ================= PAGINATION ================= -->

                <div class="pagination-section">

                    <div class="info-data">

                        Menampilkan

                        <strong>{{ $portfolios->firstItem() ?? 0 }}</strong>

                        -

                        <strong>{{ $portfolios->lastItem() ?? 0 }}</strong>

                        dari

                        <strong>{{ $portfolios->total() }}</strong>

                        data

                    </div>

                    <div class="pagination-controls">

                        {{-- Previous --}}
                        @if ($portfolios->onFirstPage())

                            <button class="page-btn" disabled>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                        @else

                            <a href="{{ $portfolios->previousPageUrl() }}" class="page-btn">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>

                        @endif

                        <span id="pageInfo">

                            Halaman

                            {{ $portfolios->currentPage() }}

                            dari

                            {{ $portfolios->lastPage() }}

                        </span>

                        {{-- Next --}}
                        @if ($portfolios->hasMorePages())

                            <a href="{{ $portfolios->nextPageUrl() }}" class="page-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>

                        @else

                            <button class="page-btn" disabled>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>

                        @endif

                    </div>

                </div>

    </div>

</div>
    <!-- ================= DETAIL PORTFOLIO MODAL ================= -->

    <div class="modal fade" id="detailPortfolioModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content portfolio-modal-content">

                <!-- HEADER -->

                <div class="modal-header portfolio-modal-header">

                    <h5 class="modal-title portfolio-modal-title">

                        Detail Portfolio

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">

                    </button>

                </div>


                <!-- BODY -->

                <div class="modal-body portfolio-modal-body">

                    <!-- Judul -->

                    <div class="portfolio-detail-group">

                        <label class="portfolio-label">

                            Judul

                        </label>

                        <p id="detailTitle" class="portfolio-value"></p>

                    </div>



                    <!-- Kategori & Mitra -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Kategori

                                </label>

                                <p id="detailCategory" class="portfolio-value"></p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Mitra

                                </label>

                                <p id="detailPartner" class="portfolio-value"></p>

                            </div>

                        </div>

                    </div>



                    <!-- Tanggal & Lokasi -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Tanggal Kegiatan

                                </label>

                                <p id="detailDate" class="portfolio-value"></p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Lokasi

                                </label>

                                <p id="detailLocation" class="portfolio-value"></p>

                            </div>

                        </div>

                    </div>



                    <!-- MAP -->

                    <div class="portfolio-detail-group">

                        <label class="portfolio-label">

                            Lokasi Peta

                        </label>

                        <div
                            id="detail-map"
                            class="portfolio-map">

                        </div>

                        <a
                            id="googleMapsButton"
                            target="_blank"
                            class="portfolio-btn-map">

                            <i class="fa-solid fa-location-dot"></i>

                            Buka di Google Maps

                        </a>

                    </div>



                    <!-- Peserta & Author -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Jumlah Peserta

                                </label>

                                <p id="detailParticipants" class="portfolio-value"></p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="portfolio-detail-group">

                                <label class="portfolio-label">

                                    Author

                                </label>

                                <p id="detailAuthor" class="portfolio-value"></p>

                            </div>

                        </div>

                    </div>



                    <!-- MEDIA -->

                    <div class="portfolio-detail-group">

                        <label class="portfolio-label">

                            Media Dokumentasi

                        </label>

                        <div
                            id="detailMedia"
                            class="portfolio-media">

                        </div>

                    </div>



                    <!-- DESKRIPSI -->

                    <div class="portfolio-detail-group">

                        <label class="portfolio-label">

                            Deskripsi

                        </label>

                        <div
                            id="detailDescription"
                            class="portfolio-description">

                        </div>

                    </div>

                </div>



                <!-- FOOTER -->

                <div class="modal-footer portfolio-modal-footer">

                    <button
                        type="button"
                        class="portfolio-btn-close"
                        data-bs-dismiss="modal">

                        <i class="fa-solid fa-xmark"></i>

                        Tutup

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection



@push('scripts')

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="{{ asset('js/admin/portfolio.js') }}"></script>

@endpush