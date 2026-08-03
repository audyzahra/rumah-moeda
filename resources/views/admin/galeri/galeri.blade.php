@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
    @endpush

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="content">

        <header class="topbar">
            <div>
                <h1>Manajemen Dokumentasi</h1>
                <p>Kelola foto-foto dokumentasi kegiatan</p>
            </div>
        </header>

        <form method="GET" class="filter-section" id="galleryFilter">

            <input
                type="hidden"
                name="per_page"
                id="perPageHidden"
                value="{{ request('per_page', 5) }}">
                
            <div class="filter-left">

                <input type="text" id="searchInput" name="search" class="search-input" 
                        value="{{ request('search') }}"
                        placeholder="Cari dokumentasi...">

                <select id="sortGallery" name="sort" class="filter-select">

                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                        Terbaru
                    </option>

                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        Terlama
                    </option>

                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                        Judul A-Z
                    </option>

                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                        Judul Z-A
                    </option>

                </select>

            </div>

            <div class="filter-right">

                <a href="{{ route('admin.gallery.create') }}" class="btn-tambah">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Galeri
                </a>

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="btn-refresh">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>

            </div>

        </form>

        <section class="table-section">

            <div class="table-wrapper">

                <table class="gallery-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Penulis</th>
                            <th>Jumlah Media</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                    <tbody id="galleryTable">

                        @forelse($galleries as $gallery)
                            @php
                                $thumbnail = $gallery->media->first();
                            @endphp


                            <tr>
                                <td>
                                    {{ $galleries->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $gallery->title }}
                                    </strong>
                                </td>



                                <td>
                                    {{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}
                                </td>



                                <td>
                                    {{ Str::limit(strip_tags($gallery->description, 60)) }}
                                </td>

                                <td>
                                    {{ $gallery->author?->name ?? '-' }}
                                </td>


                                <td>
                                    {{ $gallery->media->count() }} Media
                                </td>


                                <td>
                                    <div class="action-column">

                                        <!-- Detail -->
                                        <button type="button" class="action-btn detail" data-title="{{ $gallery->title }}"
                                            data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                            data-description='@json($gallery->description)'
                                            data-media='@json($gallery->media)' onclick="showDetail(this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="action-btn edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>


                        @empty

                            {{-- UNTUK JIKA TIDAK ADA DATA DI DB --}}
                            <tr>
                                <td colspan="7" class="empty-table">
                                    Belum ada dokumentasi
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>


            </div>


            <!-- ================= PAGINATION ================= -->

            <div class="custom-pagination">

                {{-- ==========================
                    SHOW ENTRIES
                ========================== --}}
                <div class="pagination-left">

                    <form method="GET" id="perPageForm">

                        @foreach(request()->except('per_page','page') as $key => $value)

                            <input
                                type="hidden"
                                name="{{ $key }}"
                                value="{{ $value }}">

                        @endforeach

                        <span>Tampilkan</span>

                        <select
                            name="per_page"
                            id="perPageSelect"
                            onchange="this.form.submit()">

                            <option value="5" {{ request('per_page',5)==5 ? 'selected' : '' }}>
                                5
                            </option>

                            <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>
                                10
                            </option>

                            <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>
                                20
                            </option>

                            <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>
                                50
                            </option>

                        </select>

                        <span>Galeri</span>

                    </form>

                </div>


                {{-- ==========================
                    INFO DATA
                ========================== --}}
                <div class="pagination-center">

                    <span>Menampilkan</span>

                    <strong>{{ $galleries->firstItem() ?? 0 }}</strong>

                    <span>-</span>

                    <strong>{{ $galleries->lastItem() ?? 0 }}</strong>

                    <span>dari</span>

                    <strong>{{ $galleries->total() }}</strong>

                    <span>data</span>

                </div>


                {{-- ==========================
                    PAGINATION
                ========================== --}}
                <div class="pagination-right">

                    {{-- Previous --}}
                    @if($galleries->onFirstPage())

                        <button class="page-btn" disabled>

                            <i class="fa-solid fa-chevron-left"></i>

                        </button>

                    @else

                        <a href="{{ $galleries->previousPageUrl() }}" class="page-btn">

                            <i class="fa-solid fa-chevron-left"></i>

                        </a>

                    @endif


                    @php

                        $start = max($galleries->currentPage() - 1, 1);

                        $end = min($start + 1, $galleries->lastPage());

                        if($end - $start < 1){

                            $start = max($end - 1, 1);

                        }

                    @endphp


                    @for($page = $start; $page <= $end; $page++)

                        @if($page == $galleries->currentPage())

                            <span class="page-number active">

                                {{ $page }}

                            </span>

                        @else

                            <a href="{{ $galleries->url($page) }}"
                            class="page-number">

                                {{ $page }}

                            </a>

                        @endif

                    @endfor


                    {{-- Next --}}
                    @if($galleries->hasMorePages())

                        <a href="{{ $galleries->nextPageUrl() }}" class="page-btn">

                            <i class="fa-solid fa-chevron-right"></i>

                        </a>

                    @else

                        <button class="page-btn" disabled>

                            <i class="fa-solid fa-chevron-right"></i>

                        </button>

                    @endif

                </div>

            </div>

        </section>
    </div>



    <!-- Modal Detail -->
    <div id="detailModal" class="modal" style="display:none;">

        <div class="modal-content modal-large">

            <div class="modal-header">
                <h2>Detail Galeri</h2>

                <button type="button" class="close-modal" onclick="closeDetailModal()">
                    &times;
                </button>
            </div>

            <div class="modal-body">

                <div class="detail-image">

                    <div id="detail_media"></div>

                </div>

                <div class="detail-content">

                    <div class="detail-item">
                        <label>Judul</label>
                        <p id="detail_title"></p>
                    </div>

                    <div class="detail-item">
                        <label>Tanggal Kegiatan</label>
                        <p id="detail_date"></p>
                    </div>

                    <div class="detail-item">
                        <label>Deskripsi</label>
                        <p id="detail_description"></p>
                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush
