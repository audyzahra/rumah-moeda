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
                action="{{ route('admin.organization-structures.index') }}"
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

           
            <a href="{{ route('admin.organization-structures.export') }}"
                class="btn-export">

                <i class="fa-solid fa-file-export"></i>
                Export
            </a>

            <button
                class="btn-import"
                data-bs-toggle="modal"
                data-bs-target="#importModal">

                <i class="fa-solid fa-file-import"></i>
                Import

            </button>

            <button 
                type="button"
                class="btn-refresh"
                onclick="location.reload()">

                <i class="fa-solid fa-rotate-right"></i>
            </button>

            <a href="{{ route('admin.organization-structures.create') }}" class="btn-tambah">
                <i class="fa-solid fa-plus"></i>
                Tambah Anggota
            </a>

        </section>

        <!-- ===== GRID STRUKTUR ===== -->
        <section class="struktur-grid-section">

            <div class="struktur-grid">

                @forelse($struktur as $anggota)

                <div class="struktur-card"
                data-name="{{ strtolower($anggota->full_name) }}"
                data-position="{{ strtolower($anggota->position) }}">

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
    <i class="fa-solid fa-sitemap"></i>

    <strong>
        {{ $anggota->parent_id ? 'Child' : 'Parent' }}
    </strong>
</div>

                        <div class="card-deskripsi">

                            {{ $anggota->description
                                ? Str::limit($anggota->description, 100)
                                : 'Belum ada deskripsi.' }}

                        </div>

                        <div class="card-actions">

                         <button
        type="button"
        class="btn-detail"
        onclick="openDetailModal(this)"
        data-photo="{{ $anggota->photo ? asset('storage/'.$anggota->photo) : '' }}"
        data-name="{{ $anggota->full_name }}"
        data-position="{{ $anggota->position }}"
        data-parent="{{ $anggota->parent_id ? 'Child' : 'Parent' }}"
        data-description="{{ $anggota->description }}">

        <i class="fa-solid fa-eye"></i>
        Detail
    </button>
                            <a href="{{ route('admin.organization-structures.edit', $anggota->id) }}" class="btn-edit">
                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.organization-structures.destroy', $anggota->id) }}"
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

       <!-- ===== Modal Detail ===== -->

<div id="detailModal" class="modal">

    <div class="modal-content">

        <span class="close" onclick="closeDetailModal()">&times;</span>

        <div id="detailBody"></div>

    </div>

</div>

        <!-- ===== NOTIFIKASI ===== -->
    <div id="notification" class="notification"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('admin.organization-structures.import') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Import Data Struktur Organisasi
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <label class="form-label">
                            Pilih File Excel
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                            accept=".xlsx,.xls"
                            required>

                        <small class="text-muted">
                            Format yang didukung:
                            .xlsx dan .xls
                        </small>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fa-solid fa-file-import"></i>
                            Import

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/struktur.js') }}"></script>
@endpush