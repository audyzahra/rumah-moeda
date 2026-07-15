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

    <form method="GET" class="filter-section">

    <div class="filter-left">

        <input
        type="text"
        id="searchInput"
        class="search-input"
        placeholder="Cari dokumentasi...">

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
                Tambah Galeri

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
                    <div
                    class="dokumentasi-card"
                    data-title="{{ strtolower($gallery->title) }}"
                    data-description="{{ strtolower($gallery->description) }}"
                    data-date="{{ strtolower(\Carbon\Carbon::parse($gallery->activity_date)->format('d M Y')) }}">

                        @php
                            $thumbnail = $gallery->media->first();
                        @endphp

                        @if($thumbnail)

                            @if($thumbnail->type == 'image')

                                <img
                                    src="{{ asset('storage/'.$thumbnail->file_path) }}"
                                    class="foto">

                            @else

                                <img
                                    src="https://img.youtube.com/vi/{{ $thumbnail->youtube_id }}/hqdefault.jpg"
                                    class="foto">

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

                                <button
                                    type="button"
                                    class="btn-detail"
                                    data-title="{{ $gallery->title }}"
                                    data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                    data-description="{{ $gallery->description }}"
                                    data-media='@json($gallery->media)'
                                    onclick="showDetail(this)">

                                    <i class="fa-solid fa-eye"></i>

                                </button>

                                <button
                                    type="button"
                                    class="btn-edit"
                                    data-media='@json($gallery->media)'
                                    onclick="editGallery(this,
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
                <h3>Tambah Galeri</h3>

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

                <div id="photo-container">

                <div class="form-group">

                    <label>Foto</label>

                    <input
                        type="file"
                        name="images[]"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                </div>

            </div>

            <button
                type="button"
                id="btn-add-photo"
                class="btn btn-secondary">

                + Tambah Foto

            </button>

                <div id="video-container">

                    <div class="form-group">

                        <label>Video YouTube</label>

                        <input
                            type="url"
                            name="videos[]"
                            class="form-control"
                            placeholder="https://www.youtube.com/watch?v=xxxx">

                        <small class="text-muted">
                            Tambahkan satu atau lebih link video YouTube (opsional).
                        </small>

                    </div>

                </div>

                <button
                    type="button"
                    id="btn-add-video"
                    class="btn btn-secondary">

                    + Tambah Link Video

                </button>

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
                <h3>Edit Galeri</h3>

                <button type="button"
                        class="close-modal"
                        onclick="closeEditModal()">
                    &times;
                </button>
            </div>

            <form
                id="editForm"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

            <div class="form-group">
                <label>Judul</label>
                <input
                    type="text"
                    name="title"
                    id="edit_title"
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Tanggal Kegiatan</label>
                <input
                    type="date"
                    name="activity_date"
                    id="edit_activity_date"
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea
                    name="description"
                    id="edit_description"
                    class="form-control"
                    rows="4"></textarea>
            </div>

            {{-- Media yang sudah ada --}}
            <div class="form-group">
                <label>Media Saat Ini</label>

                <div id="existingMedia">

                    <p class="text-muted">
                        Belum ada media.
                    </p>

                </div>
            </div>

            <div id="edit-photo-container">

                <div class="form-group">

                    <label>Tambah Foto</label>

                    <input
                        type="file"
                        name="images[]"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB per file.
                    </small>

                </div>

            </div>

            <button
                type="button"
                id="btn-edit-add-photo"
                class="btn btn-secondary">

                + Tambah Foto

            </button>

            <div id="edit-video-container">

                <div class="form-group">

                    <label>Tambah Video YouTube</label>

                    <input
                        type="url"
                        name="videos[]"
                        class="form-control"
                        placeholder="https://www.youtube.com/watch?v=xxxx">

                </div>

            </div>

                <button
                    type="button"
                    id="btn-edit-add-video"
                    class="btn btn-secondary">

                    + Tambah Link Video

                </button>

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
                <h2>Detail Galeri</h2>

                <button
                    type="button"
                    class="close-modal"
                    onclick="closeDetailModal()">
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

        </div>

    </div>

    <!-- ===== NOTIFIKASI ===== -->
    <div id="notification" class="notification"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>


@endsection

@push('scripts')
<script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush