@extends('admin.layouts.app')

@section('title', 'Manajemen Struktur Organisasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
@endpush

@section('content')

<!-- @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif -->

<div class="wrapper">

    <main class="content">

        <!-- HEADER -->
        <header class="topbar">
            <div>
                <h1>Manajemen Struktur Organisasi</h1>
                <p>Kelola data anggota struktur organisasi</p>
            </div>
        </header>

        <!-- ===== FILTER & SEARCH ===== -->
        <section class="filter-section">
            <form method="GET"
                action="{{ route('admin.struktur.index') }}"
                class="filter-left"
                id="filterForm">

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau jabatan..."
                    class="search-input">

                <select
                    name="jabatan"
                    class="filter-select"
                    onchange="document.getElementById('filterForm').submit()">

                    <option value="">Semua Jabatan</option>

                    @foreach($jabatanList as $jabatan)
                        <option value="{{ $jabatan }}"
                            {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                            {{ $jabatan }}
                        </option>
                    @endforeach

                </select>

                <select
                    name="sort"
                    class="filter-select"
                    onchange="document.getElementById('filterForm').submit()">

                    <option value="">Urutkan</option>

                    <option value="terbaru"
                        {{ request('sort')=='terbaru'?'selected':'' }}>
                        Terbaru
                    </option>

                    <option value="terlama"
                        {{ request('sort')=='terlama'?'selected':'' }}>
                        Terlama
                    </option>

                    <option value="nama_asc"
                        {{ request('sort')=='nama_asc'?'selected':'' }}>
                        Nama A-Z
                    </option>

                    <option value="nama_desc"
                        {{ request('sort')=='nama_desc'?'selected':'' }}>
                        Nama Z-A
                    </option>

                </select>

            </form>

           <button type="button"
                class="btn-tambah"
                data-bs-toggle="modal"
                data-bs-target="#formModal">
                <i class="fa-solid fa-plus"></i>
                Tambah Anggota
            </button>

            <button 
                type="button"
                class="btn-refresh"
                onclick="location.reload()">

                <i class="fa-solid fa-rotate-right"></i>
            </button>

        </section>

        <!-- ===== GRID STRUKTUR ===== -->
        <section class="struktur-grid-section">

            <div class="struktur-grid">

                @forelse($struktur as $anggota)

                <div class="struktur-card">

                    <span class="badge-order">
                        #{{ $anggota->display_order }}
                    </span>

                    <div class="foto-wrapper">

                        @if($anggota->photo)

                            <img
                                src="{{ asset('storage/' . $anggota->photo) }}"
                                alt="{{ $anggota->full_name }}"
                                class="foto">

                        @else

                            <div class="foto-placeholder">
                                <i class="fa-solid fa-user"></i>
                            </div>

                        @endif

                    </div>

                    <div class="card-body">

                        <div class="card-name">
                            {{ $anggota->full_name }}
                        </div>

                        <div class="card-position">
                            {{ $anggota->position }}
                        </div>

                        <div class="card-periode">
                            <i class="fa-solid fa-arrow-down-1-9"></i>
                            Urutan {{ $anggota->display_order }}
                        </div>

                        <div class="card-deskripsi">

                            {{ $anggota->description
                                ? Str::limit($anggota->description, 100)
                                : 'Belum ada deskripsi.' }}

                        </div>

                        <!-- <span class="card-status tampil">
                            Ditampilkan
                        </span> -->

                        <div class="card-actions">

                            <button type="button"
                                class="btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-id="{{ $anggota->id }}"
                                data-name="{{ $anggota->full_name }}"
                                data-position="{{ $anggota->position }}"
                                data-order="{{ $anggota->display_order }}"
                                data-description="{{ $anggota->description }}">

                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </button>

                            <form
                                action="{{ route('admin.struktur.destroy', $anggota->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">

                                    <i class="fa-solid fa-trash"></i>
                                    Hapus

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                @empty

                <div class="empty-state">

                    <i class="fa-solid fa-users-slash"></i>

                    <h3>Tidak ada data anggota</h3>

                    <p>Belum ada data struktur organisasi yang tersedia.</p>

                </div>

                @endforelse

            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="pagination-section">

                <div class="info-data">

                    Menampilkan
                    {{ $struktur->firstItem() ?? 0 }}
                    -
                    {{ $struktur->lastItem() ?? 0 }}

                    dari

                    {{ $struktur->total() }}

                    anggota

                </div>

                <div class="pagination-controls">

                    {{ $struktur->withQueryString()->links() }}

                </div>

            </div>

        </section>

       <!-- ===== MODAL TAMBAH ===== -->
        <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('admin.struktur.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Tambah Anggota Struktur
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>

                                    <input
                                        type="text"
                                        name="full_name"
                                        class="form-control"
                                        value="{{ old('full_name') }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jabatan
                                    </label>

                                    <input
                                        type="text"
                                        name="position"
                                        class="form-control"
                                        value="{{ old('position') }}"
                                        required>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Urutan Tampil
                                    </label>

                                    <input
                                        type="number"
                                        name="display_order"
                                        min="1"
                                        class="form-control"
                                        value="{{ old('display_order') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Upload Foto
                                    </label>

                                    <input
                                        type="file"
                                        name="photo"
                                        accept="image/*"
                                        class="form-control">
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Deskripsi / Biografi
                                </label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="form-control">{{ old('description') }}</textarea>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit"
                                    class="btn btn-primary">
                                <i class="fa-solid fa-save"></i>
                                Simpan
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- ===== MODAL EDIT ===== -->
        <div class="modal fade" id="editModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <form id="editForm"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')


                        <div class="modal-header">

                            <h5 class="modal-title">
                                Edit Anggota Struktur
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>


                        <div class="modal-body">


                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>

                                    <input type="text"
                                        id="editName"
                                        name="full_name"
                                        class="form-control"
                                        required>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Jabatan
                                    </label>

                                    <input type="text"
                                        id="editPosition"
                                        name="position"
                                        class="form-control"
                                        required>

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Urutan Tampil
                                    </label>

                                    <input type="number"
                                        id="editOrder"
                                        name="display_order"
                                        class="form-control">

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Upload Foto
                                    </label>

                                    <input type="file"
                                        name="photo"
                                        class="form-control">

                                </div>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Deskripsi
                                </label>

                                <textarea
                                    id="editDescription"
                                    name="description"
                                    rows="4"
                                    class="form-control"></textarea>

                            </div>


                        </div>


                        <div class="modal-footer">

                            <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Batal

                            </button>


                            <button type="submit"
                                class="btn btn-primary">

                                <i class="fa-solid fa-save"></i>
                                Update

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

        <!-- ===== NOTIFIKASI ===== -->
<div id="notification" class="notification"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    @if(session('success'))
        showNotification("{{ session('success') }}", "success");
    @endif

    @if(session('error'))
        showNotification("{{ session('error') }}", "error");
    @endif

});
</script>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/struktur.js') }}"></script>
@endpush
