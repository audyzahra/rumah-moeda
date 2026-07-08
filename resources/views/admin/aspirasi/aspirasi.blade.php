@extends('admin.layouts.app')

@section('title','Aspirasi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/aspirasi.css') }}">
@endpush

@section('content')

<!-- ================= HEADER ================= -->
<div class="page-header">
    <h1>Manajemen Aspirasi</h1>
    <p>Kelola semua aspirasi dari pengunjung</p>
</div>

<!-- ================= FILTER ================= -->
<div class="filter-section">

    <div class="filter-left">

        <input
            type="text"
            id="searchInput"
            class="search-input"
            placeholder="Cari aspirasi..."
        >

        <select id="filterStatus" class="filter-select">
            <option value="semua">Semua Status</option>
            <option value="baru">Baru</option>
            <option value="dibaca">Dibaca</option>
            <option value="approved">Approved</option>
        </select>

        <select id="filterSort" class="filter-select">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
        </select>

    </div>

    <div class="filter-right">

        <button class="btn-refresh" onclick="location.reload()">
            <i class="fa-solid fa-rotate"></i>
            Refresh
        </button>

        <button class="btn-hapus-bulk">
            <i class="fa-solid fa-trash"></i>
            Hapus Terpilih
        </button>

    </div>

</div>

<!-- ================= TABLE ================= -->
<div class="table-section">

    <div class="table-wrapper">

        <table id="aspirasiTable">

            <thead>
                <tr>
                    <th width="40">
                        <input
                            type="checkbox"
                            id="checkAll"
                            onchange="toggleAllCheckbox()"
                        >
                    </th>

                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody id="aspirasiBody">
                <!-- diisi JS -->
            </tbody>

        </table>

    </div>

    <!-- ================= PAGINATION ================= -->

    <div class="pagination-section">

        <div class="info-data">
            Menampilkan
            <span id="startData">0</span>
            -
            <span id="endData">0</span>
            dari
            <span id="totalData">0</span>
            data
        </div>

        <div class="pagination-controls">

            <button
                class="page-btn"
                id="prevBtn"
                onclick="prevPage()">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <span id="pageInfo">
                Halaman 1
            </span>

            <button
                class="page-btn"
                id="nextBtn"
                onclick="nextPage()">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

    </div>

</div>

<!-- ================= MODAL DETAIL ================= -->

<div id="detailModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Detail Aspirasi</h2>

            <span
                class="modal-close"
                onclick="closeModal()">
                &times;
            </span>

        </div>

        <div
            class="modal-body"
            id="detailBody">

        </div>

    </div>

</div>

<!-- ================= MODAL HAPUS ================= -->

<div id="deleteModal" class="modal">

    <div
        class="modal-content"
        style="max-width:420px;">

        <div class="modal-header">

            <h2>Konfirmasi</h2>

            <span
                class="modal-close"
                onclick="closeDeleteModal()">
                &times;
            </span>

        </div>

        <div class="modal-body">

            <p>
                Yakin ingin menghapus aspirasi ini?
            </p>

            <div
                style="display:flex;
                       justify-content:flex-end;
                       gap:10px;
                       margin-top:25px;">

                <button
                    class="btn-refresh"
                    onclick="closeDeleteModal()">
                    Batal
                </button>

                <button
                    class="btn-hapus"
                    onclick="deleteData()">
                    Hapus
                </button>

            </div>

        </div>

    </div>

</div>

<!-- ================= NOTIFICATION ================= -->

<div
    id="notification"
    class="notification">
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/aspirasi.js') }}"></script>
@endpush
