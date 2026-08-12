@extends('admin.layouts.app')

@section('title', 'Manajemen Struktur Organisasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
@endpush
@php
    use Illuminate\Support\Facades\Crypt;
@endphp
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
                <form  method="GET"
                        action="{{ route('admin.organization-structures.index') }}"
                        class="filter-left" id="filterForm">

                    <input
                    type="hidden"
                    name="per_page"
                    value="{{ request('per_page',5) }}">

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

                <a
                    href="{{ route('admin.organization-structures.index') }}"
                    class="btn-refresh">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>

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

                                            <a href="{{ route('admin.organization-structures.edit', Crypt::encryptString($anggota->id)) }}"
                                                class="btn-edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                           <form action="{{ route('admin.organization-structures.destroy', Crypt::encryptString($anggota->id)) }}"
                                                method="POST">
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
                                    <td colspan="6" class="text-center">
                                        Tidak ada data struktur organisasi.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- UNTUK SEARCH KETIKA DATA TIDAK DITEMUKAN --}}

                            <tr id="emptySearchRow" style="display:none;">
                                <td colspan="6" class="text-center">
                                    Data struktur organisasi tidak ditemukan.
                                </td>
                            </tr>


                        </tbody>

                    </table>
                </div>

                <!-- ================= PAGINATION ================= -->

                <div class="custom-pagination">

                    {{-- ==========================================
                        SHOW ENTRIES
                    ========================================== --}}
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

                            <span>Anggota</span>

                        </form>

                    </div>


                    {{-- ==========================================
                        INFO DATA
                    ========================================== --}}
                    <div class="pagination-center">

                        <span>Menampilkan</span>

                        <strong>{{ $struktur->firstItem() ?? 0 }}</strong>

                        <span>-</span>

                        <strong>{{ $struktur->lastItem() ?? 0 }}</strong>

                        <span>dari</span>

                        <strong>{{ $struktur->total() }}</strong>

                        <span>data</span>

                    </div>


                    {{-- ==========================================
                        PAGINATION
                    ========================================== --}}
                    <div class="pagination-right">

                        {{-- Previous --}}
                        @if($struktur->onFirstPage())

                            <button class="page-btn" disabled>

                                <i class="fa-solid fa-chevron-left"></i>

                            </button>

                        @else

                            <a
                                href="{{ $struktur->previousPageUrl() }}"
                                class="page-btn">

                                <i class="fa-solid fa-chevron-left"></i>

                            </a>

                        @endif


                        @php

                            $start = max($struktur->currentPage() - 1, 1);

                            $end = min($start + 1, $struktur->lastPage());

                            if($end - $start < 1){

                                $start = max($end - 1, 1);

                            }

                        @endphp


                        @for($page = $start; $page <= $end; $page++)

                            @if($page == $struktur->currentPage())

                                <span class="page-number active">

                                    {{ $page }}

                                </span>

                            @else

                                <a
                                    href="{{ $struktur->url($page) }}"
                                    class="page-number">

                                    {{ $page }}

                                </a>

                            @endif

                        @endfor


                        {{-- Next --}}
                        @if($struktur->hasMorePages())

                            <a
                                href="{{ $struktur->nextPageUrl() }}"
                                class="page-btn">

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
