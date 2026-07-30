@extends('admin.layouts.app')

@section('title', 'Manajemen Struktur Organisasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
@endpush

@section('content')

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
                <form class="filter-left" id="filterForm">

                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau jabatan..." class="search-input">

                    <select id="jabatanFilter" name="jabatan" class="filter-select">

                        <option value="">Semua Jabatan</option>

                        @foreach ($jabatanList as $jabatan)
                            <option value="{{ $jabatan }}" {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                                {{ $jabatan }}
                            </option>
                        @endforeach

                    </select>

                    <select id="sortSelect" name="sort" class="filter-select">

                        <option value="">Urutkan</option>

                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                            Terbaru
                        </option>

                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                            Terlama
                        </option>

                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>
                            Nama A-Z
                        </option>

                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>
                            Nama Z-A
                        </option>

                    </select>

                </form>


                <a href="{{ route('admin.organization-structures.export') }}" class="btn-export">

                    <i class="fa-solid fa-file-export"></i>
                    Export
                </a>

                <button class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">

                    <i class="fa-solid fa-file-import"></i>
                    Import

                </button>

                <a href="{{ route('admin.organization-structures.template') }}"
                    class="btn btn-primary">

                    <i class="fas fa-file-excel"></i>

                    Template

                </a>

                <button type="button" class="btn-refresh" onclick="location.reload()">

                    <i class="fa-solid fa-rotate-right"></i>
                </button>

                <a href="{{ route('admin.organization-structures.create') }}" class="btn-tambah">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Anggota
                </a>

            </section>

            <!-- ===== TABEL STRUKTUR ===== -->
            <section class="struktur-table-section">

                <div class="table-responsive">
                    <table class="table-struktur">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                                <th width="170">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="strukturTable">

                            @forelse($struktur as $index => $anggota)
                                <tr data-name="{{ strtolower($anggota->full_name) }}"
                                    data-position="{{ strtolower($anggota->position) }}">
                                    <td>
                                        {{ $struktur->firstItem() + $index }}
                                    </td>

                                    <td>
                                        @if ($anggota->photo)
                                            <img src="{{ asset('storage/' . $anggota->photo) }}" class="table-photo"
                                                alt="{{ $anggota->full_name }}">
                                        @else
                                            <div class="table-photo-placeholder">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ $anggota->full_name }}</td>

                                    <td>{{ $anggota->position }}</td>

                                    <td>
                                        <span class="badge {{ $anggota->parent_id ? 'badge-child' : 'badge-parent' }}">
                                            {{ $anggota->parent_id ? 'Child' : 'Parent' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ Str::limit(strip_tags(html_entity_decode($anggota->description)), 80) ?: '-' }}
                                    </td>

                                    <td>

                                        <div class="table-action">

                                            <button type="button" class="btn-detail" onclick="openDetailModal(this)"
                                                data-photo="{{ $anggota->photo ? asset('storage/' . $anggota->photo) : '' }}"
                                                data-name="{{ $anggota->full_name }}"
                                                data-position="{{ $anggota->position }}"
                                                data-parent="{{ $anggota->parent_id ? 'Child' : 'Parent' }}"
                                                data-description="{{ $anggota->description }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.organization-structures.edit', $anggota->id) }}"
                                                class="btn-edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.organization-structures.destroy', $anggota->id) }}"
                                                method="POST" class="delete-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                {{-- INI UNTUK LARAVEL/DB KETIKA DATA TIDAK ADA --}}

                                <tr>
                                    <td colspan="7" class="text-center">
                                        Tidak ada data struktur organisasi.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- UNTUK SEARCH KETIKA DATA TIDAK DITEMUKAN --}}

                            <tr id="emptySearchRow" style="display:none;">
                                <td colspan="7" class="text-center">
                                    Data struktur organisasi tidak ditemukan.
                                </td>
                            </tr>


                        </tbody>

                    </table>
                </div>

                <!-- ================= PAGINATION ================= -->

                <div class="pagination-section">

                    <div class="info-data">

                        Menampilkan

                        <strong>{{ $struktur->firstItem() ?? 0 }}</strong>

                        -

                        <strong>{{ $struktur->lastItem() ?? 0 }}</strong>

                        dari

                        <strong>{{ $struktur->total() }}</strong>

                        data

                    </div>

                    <div class="pagination-controls">

                        {{-- Previous --}}
                        @if ($struktur->onFirstPage())
                            <button class="page-btn" disabled>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                        @else
                            <a href="{{ $struktur->previousPageUrl() }}" class="page-btn">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        @endif

                        <span id="pageInfo">

                            Halaman

                            {{ $struktur->currentPage() }}

                            dari

                            {{ $struktur->lastPage() }}

                        </span>

                        {{-- Next --}}
                        @if ($struktur->hasMorePages())
                            <a href="{{ $struktur->nextPageUrl() }}" class="page-btn">
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

            </section>

            <!-- ===== Modal Detail ===== -->

            <div id="detailModal" class="detail-modal">

                <div class="modal-content">

                    <span class="close" onclick="closeDetailModal()">&times;</span>

                    <div id="detailBody"></div>

                </div>

            </div>

            <!-- Modal Import -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form action="{{ route('admin.organization-structures.import') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Import Data Struktur Organisasi
                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="modal-body">

                                <label class="form-label">
                                    Pilih File Excel
                                </label>

                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                                <small class="text-muted">
                                    Format yang didukung:
                                    .xlsx dan .xls
                                </small>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <button type="submit" class="btn btn-primary">

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
