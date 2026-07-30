@extends('user.layouts.app')
@section('title', 'Galeri')
@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
    @endpush


    <div class="content">

        {{-- ================= HEADER ================= --}}
        <header class="topbar">

            <div>

                <h1>Manajemen Dokumentasi</h1>

                <p>Kelola foto-foto dokumentasi kegiatan</p>

            </div>

        </header>

        {{-- ================= FILTER ================= --}}
        <form method="GET" id="filterForm" class="filter-section">

            <div class="filter-left">

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    class="search-input"
                    placeholder="Cari dokumentasi..."
                    value="{{ request('search') }}">

                <select
                    id="sortGallery"
                    name="sort"
                    class="filter-select">

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

                <a href="{{ route('user.gallery.create') }}" class="btn-tambah">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Galeri

                </a>

                <button type="button" class="btn-refresh" onclick="location.reload()">

                    <i class="fa-solid fa-rotate-right"></i>

                </button>

            </div>

        </form>

        {{-- ================= TABLE ================= --}}
        <section class="table-section">

            <div class="table-wrapper">

                <table class="gallery-table" id="galleryTable">

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

                            <tr
                            data-title="{{ strtolower($gallery->title) }}"
                            data-description="{{ strtolower(strip_tags($gallery->description)) }}"
                            data-date="{{ strtotime($gallery->activity_date) }}">

                                <td>
                                    {{ ($galleries->currentPage() - 1) * $galleries->perPage() + $loop->iteration }}
                                </td>

                                

                                <td>
                                    <strong>{{ $gallery->title }}</strong>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ Str::limit(strip_tags(html_entity_decode($gallery->description)), 80) }}
                                </td>
                                
                                <td>
                                    {{ $gallery->author?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $gallery->media->count() }} Media
                                </td>

                                <td>

                                    <div class="action-column">

                                        {{-- Detail --}}
                                        <button type="button" class="action-btn detail" data-title="{{ $gallery->title }}"
                                            data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                            data-description='@json($gallery->description)'
                                            data-media='@json($gallery->media)' onclick="showDetail(this)">

                                            <i class="fa-solid fa-eye"></i>

                                        </button>

                                        {{-- Edit --}}
                                        <a href="{{ route('user.gallery.edit', $gallery->id) }}" class="action-btn edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('user.gallery.destroy', $gallery->id) }}" method="POST"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="empty-table">
                                    Belum ada dokumentasi.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- ================= PAGINATION ================= -->

            <div class="custom-pagination">

    <div class="pagination-left">

        <form method="GET">

            @foreach(request()->except('per_page','page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <span>Tampilkan</span>

            <select name="per_page" onchange="this.form.submit()">
                <option value="5" {{ request('per_page',5)==5?'selected':'' }}>5</option>
                <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                <option value="20" {{ request('per_page')==20?'selected':'' }}>20</option>
                <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
            </select>

            <span>galeri</span>

        </form>

    </div>

    <div class="pagination-center">

        <span>Menampilkan</span>

        <strong>{{ $galleries->firstItem() ?? 0 }}</strong>

        <span>-</span>

        <strong>{{ $galleries->lastItem() ?? 0 }}</strong>

        <span>dari</span>

        <strong>{{ $galleries->total() }}</strong>

        <span>data</span>

    </div>

    <div class="pagination-right">

        @if($galleries->onFirstPage())

            <button class="page-btn" disabled>
                <i class="fa-solid fa-chevron-left"></i>
            </button>

        @else

            <a href="{{ $galleries->appends(request()->query())->previousPageUrl() }}" class="page-btn">
                <i class="fa-solid fa-chevron-left"></i>
            </a>

        @endif

        @foreach($galleries->appends(request()->query())->getUrlRange(1,$galleries->lastPage()) as $page => $url)

            @if($page==$galleries->currentPage())

                <span class="page-number active">{{ $page }}</span>

            @else

                <a href="{{ $url }}" class="page-number">{{ $page }}</a>

            @endif

        @endforeach

        @if($galleries->hasMorePages())

            <a href="{{ $galleries->appends(request()->query())->nextPageUrl() }}" class="page-btn">
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
        {{-- ================= DETAIL MODAL ================= --}}

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
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script src="{{ asset('js/admin/galeri.js') }}"></script>

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        Swal.fire({
                            icon: 'success',
                            title: '{{ session('title') ?? 'Berhasil!' }}',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#D4AF37',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                    });
                </script>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    document.querySelectorAll('.delete-form').forEach(form => {

                        form.addEventListener('submit', function(e) {

                            e.preventDefault();

                            Swal.fire({
                                title: 'Hapus Galeri?',
                                text: 'Galeri yang dihapus tidak dapat dikembalikan.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Hapus',
                                cancelButtonText: 'Batal',
                                confirmButtonColor: '#dc3545',
                                cancelButtonColor: '#6c757d',
                                reverseButtons: true
                            }).then((result) => {

                                if (result.isConfirmed) {
                                    form.submit();
                                }

                            });

                        });

                    });

                });
            </script>
        @endpush

    @endsection

    @push('scripts')
        <script src="{{ asset('js/admin/galeri.js') }}"></script>
    @endpush
