@extends('admin.layouts.app')

@section('title','FAQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

<header class="topbar">
    <div>
        <h1>Manajemen FAQ</h1>
        <p>Kelola pertanyaan yang sering diajukan</p>
    </div>
</header>

<!-- ===== FILTER ===== -->
<section class="filter-section">

    <div class="filter-left">

        <input type="text"
               id="searchInput"
               class="search-input"
               placeholder="Cari pertanyaan...">

        <select id="filterKategori" class="filter-select">
            <option value="semua">Semua Kategori</option>
        </select>

        <select id="filterStatus" class="filter-select">
            <option value="semua">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Non-Aktif</option>
        </select>

        <select id="filterSort" class="filter-select">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
            <option value="pertanyaan">Pertanyaan A-Z</option>
        </select>

    </div>

    <div class="filter-right">

        <button class="btn-tambah" onclick="openTambahModal()">
            <i class="fa-solid fa-plus"></i>
            Tambah FAQ
        </button>

        <button class="btn-refresh" onclick="refreshData()">
            <i class="fa-solid fa-rotate"></i>
        </button>

    </div>

</section>

<!-- ===== LIST FAQ ===== -->
<section class="faq-list-section">

    <div class="faq-list" id="faqList">
        <!-- Data FAQ -->
    </div>

    <div class="pagination-section">

        <div class="info-data">
            Menampilkan
            <span id="startData">0</span> -
            <span id="endData">0</span>
            dari
            <span id="totalData">0</span>
            FAQ
        </div>

        <div class="pagination-controls">

            <button class="page-btn" id="prevBtn" onclick="prevPage()">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <span id="pageInfo">Halaman 1</span>

            <button class="page-btn" id="nextBtn" onclick="nextPage()">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

    </div>

</section>

<!-- ================= MODAL TAMBAH / EDIT ================= -->

<div class="modal" id="formModal">

    <div class="modal-content modal-large">

        <div class="modal-header">
            <h2 id="formModalTitle">Tambah FAQ</h2>
            <span class="modal-close" onclick="closeFormModal()">&times;</span>
        </div>

        <div class="modal-body">

            <form id="faqForm" onsubmit="saveFaq(event)">

                <input type="hidden" id="editId">

                <div class="form-row">

                    <div class="form-group form-group-half">

                        <label>Kategori <span class="required">*</span></label>

                        <select id="formKategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                        </select>

                    </div>

                    <div class="form-group form-group-half">

                        <label>Urutan Tampil</label>

                        <input
                            type="number"
                            id="formDisplayOrder"
                            class="form-control"
                            min="1"
                            placeholder="Contoh: 1">

                        <small class="form-help">
                            Semakin kecil angka semakin atas tampilnya
                        </small>

                    </div>

                </div>

                <div class="form-group">

                    <label>Pertanyaan <span class="required">*</span></label>

                    <input
                        type="text"
                        id="formPertanyaan"
                        class="form-control"
                        placeholder="Masukkan pertanyaan"
                        required>

                </div>

                <div class="form-group">

                    <label>Jawaban <span class="required">*</span></label>

                    <textarea
                        id="formJawaban"
                        class="form-control"
                        rows="5"
                        placeholder="Masukkan jawaban"
                        required></textarea>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select id="formStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>

                </div>

                <div class="form-actions">

                    <button
                        type="button"
                        class="btn-batal"
                        onclick="closeFormModal()">
                        Batal
                    </button>

                    <button type="submit" class="btn-simpan">
                        <i class="fa-solid fa-save"></i>
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ================= DETAIL ================= -->

<div class="modal" id="detailModal">

    <div class="modal-content modal-large">

        <div class="modal-header">
            <h2>Detail FAQ</h2>
            <span class="modal-close" onclick="closeDetailModal()">&times;</span>
        </div>

        <div class="modal-body" id="detailBody"></div>

    </div>

</div>

<!-- ================= HAPUS ================= -->

<div class="modal" id="deleteModal">

    <div class="modal-content modal-delete">

        <div class="modal-header">
            <h2>Konfirmasi Hapus</h2>
            <span class="modal-close" onclick="closeDeleteModal()">&times;</span>
        </div>

        <div class="modal-body modal-delete-body">

            <i class="fa-solid fa-trash-can delete-icon"></i>

            <p class="delete-text">
                Apakah Anda yakin ingin menghapus FAQ ini?
            </p>

            <p class="delete-subtext" id="deleteInfo">
                Data akan dihapus secara permanen.
            </p>

            <div class="delete-actions">

                <button
                    class="btn-batal"
                    onclick="closeDeleteModal()">
                    Batal
                </button>

                <button
                    class="btn-hapus"
                    onclick="confirmDelete()">
                    Hapus
                </button>

            </div>

        </div>

    </div>

</div>

<div id="notification" class="notification"></div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/faq.js') }}"></script>
@endpush
