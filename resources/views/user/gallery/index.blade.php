@extends('user.layouts.app')

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
        <form method="GET" class="filter-section">

            <div class="filter-left">

                <input type="text" id="searchInput" class="search-input" placeholder="Cari dokumentasi...">

                <select name="sort" class="filter-select" onchange="this.form.submit()">

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

        {{-- ================= GRID ================= --}}
        <section class="dokumentasi-grid-section">

            <div class="dokumentasi-grid">

                @forelse($galleries as $gallery)
                    @php
                        $thumbnail = $gallery->media->first();
                    @endphp

                    <div class="dokumentasi-card" data-title="{{ strtolower($gallery->title) }}"
                        data-description="{{ strtolower($gallery->description) }}"
                        data-date="{{ strtolower(\Carbon\Carbon::parse($gallery->activity_date)->format('d M Y')) }}">

                        @if ($thumbnail)
                            @if ($thumbnail->type == 'image')
                                <img src="{{ asset('storage/' . $thumbnail->file_path) }}" class="foto"
                                    alt="{{ $gallery->title }}">
                            @else
                                <img src="https://img.youtube.com/vi/{{ $thumbnail->youtube_id }}/hqdefault.jpg"
                                    class="foto" alt="{{ $gallery->title }}">
                            @endif
                        @endif

                        <div class="card-body">

                            <h3 class="card-title">

                                {{ $gallery->title }}

                            </h3>

                            <small>

                                {{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}

                            </small>

                            <p>

                                {{ Str::limit($gallery->description, 100) }}

                            </p>

                            <div class="card-actions">

                                {{-- DETAIL --}}
                                <button type="button" class="btn-detail" data-title="{{ $gallery->title }}"
                                    data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                    data-description="{{ $gallery->description }}"
                                    data-media='@json($gallery->media)' onclick="showDetail(this)">

                                    <i class="fa-solid fa-eye"></i>

                                </button>

                                {{-- EDIT --}}
                                <a href="{{ route('user.gallery.edit', $gallery->id) }}" class="btn-edit">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('user.gallery.destroy', $gallery->id) }}" method="POST"
                                    class="delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        Belum ada dokumentasi.

                    </div>
                @endforelse

            </div>

            <div class="mt-4">

                {{ $galleries->links() }}

            </div>

        </section>

    </div>
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

                <div class="detail-item">

                    <label>Judul</label>

                    <p id="detail_title">-</p>

                </div>

                <div class="detail-item">

                    <label>Tanggal Kegiatan</label>

                    <p id="detail_date">-</p>

                </div>

                <div class="detail-item">

                    <label>Deskripsi</label>

                    <p id="detail_description">-</p>

                </div>

                <div class="detail-item">

                    <label>Media</label>

                    <div id="detail_media" class="detail-media">

                        <p class="text-muted">

                            Tidak ada media.

                        </p>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn-batal" onclick="closeDetailModal()">

                    Tutup

                </button>

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
