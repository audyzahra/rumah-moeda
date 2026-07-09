@extends('admin.layouts.app')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
@endpush

@if(session('success'))
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

    <!-- Statistik -->
    <section class="dokumentasi-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fa-solid fa-images"></i>
            </div>
            <div>
                <h4>Total Foto</h4>
                <h2>{{ $galleries->total() }}</h2>
            </div>
        </div>
    </section>

    <form method="GET" class="filter-section">

    <div class="filter-left">

        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Cari dokumentasi..."
            value="{{ request('search') }}">

        <select
            name="sort"
            class="filter-select"
            onchange="this.form.submit()">

            <option value="latest"
                {{ request('sort')=='latest' ? 'selected' : '' }}>
                Terbaru
            </option>

            <option value="oldest"
                {{ request('sort')=='oldest' ? 'selected' : '' }}>
                Terlama
            </option>

            <option value="title_asc"
                {{ request('sort')=='title_asc' ? 'selected' : '' }}>
                Judul A-Z
            </option>

            <option value="title_desc"
                {{ request('sort')=='title_desc' ? 'selected' : '' }}>
                Judul Z-A
            </option>

        </select>

    </div>

      <div class="filter-right">

           <button
                type="button"
                class="btn-tambah"
                onclick="openCreateModal()">

                <i class="fa-solid fa-plus"></i>
                Tambah Foto

            </button>

            <button
                type="button"
                class="btn-refresh"
                onclick="location.reload()">

                <i class="fa-solid fa-rotate-right"></i>

            </button>

        </div>

</form>

        <!-- Grid Gallery -->
        <section class="dokumentasi-grid-section">

            <div class="dokumentasi-grid">

                @forelse($galleries as $gallery)
                    <div class="dokumentasi-card">

                        <img
                            src="{{ asset('storage/'.$gallery->photo) }}"
                            alt="{{ $gallery->title }}"
                            class="foto"
                        >

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

                                <button
                                    type="button"
                                    class="btn-detail"
                                    data-photo="{{ asset('storage/'.$gallery->photo) }}"
                                    data-title="{{ $gallery->title }}"
                                    data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                    data-description="{{ $gallery->description }}"
                                    onclick="showDetail(this)">

                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <button
                                    type="button"
                                    class="btn-edit"
                                    onclick="editGallery(
                                        '{{ $gallery->id }}',
                                        '{{ $gallery->title }}',
                                        '{{ $gallery->activity_date }}',
                                        '{{ $gallery->description }}'
                                    )">
                                    Edit
                                </button>

                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        Hapus
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

    <!-- create -->
        <div id="createModal" class="modal">

        <div class="modal-content">

            <div class="modal-header">
                <h3>Tambah Dokumentasi</h3>

                <button type="button"
                        class="close-modal"
                        onclick="closeCreateModal()">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.gallery.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="activity_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="photo" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn-batal"
                            onclick="closeCreateModal()">
                        Batal
                    </button>

                    <button class="btn-simpan">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal" style="display:none;">
        <div class="modal-content">

            <div class="modal-header">
                <h3>Edit Dokumentasi</h3>

                <button type="button"
                        class="close-modal"
                        onclick="closeEditModal()">
                    &times;
                </button>
            </div>

            <form id="editForm"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text"
                        name="title"
                        id="edit_title"
                        class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label>Tanggal Kegiatan</label>
                    <input type="date"
                        name="activity_date"
                        id="edit_activity_date"
                        class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description"
                            id="edit_description"
                            class="form-control"
                            rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Ganti Foto (opsional)</label>
                    <input type="file"
                        name="photo"
                        class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn-batal"
                            onclick="closeEditModal()">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn-simpan">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>


   <!-- Modal Detail -->
<div id="detailModal" class="modal" style="display:none;">

    <div class="modal-content modal-large">

        <div class="modal-header">
            <h2>Detail Dokumentasi</h2>

            <button
                type="button"
                class="close-modal"
                onclick="closeDetailModal()">
                &times;
            </button>
        </div>

        <div class="modal-body">

            <img
                id="detail_photo"
                class="detail-image"
                src=""
                alt="Foto Dokumentasi">

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

        </div>

    </div>

</div>



@endsection

@push('scripts')
<script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush