@extends('admin.layouts.app')

@section('title','Mitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mitra.css') }}">
@endpush

@section('content')

<div class="wrapper">
    <!-- ================= CONTENT ================= -->
    <main class="content">

        <!-- HEADER -->
        <header class="topbar">
            <div>
                <h1>Manajemen Mitra</h1>
                <p>Kelola data mitra dan kerjasama</p>
            </div>
        </header>

        <!-- ===== FILTER & SEARCH ===== -->
        <section class="filter-section">
            <form
                method="GET"
                action="{{ route('admin.partners.index') }}"
                class="filter-form">

                <input
                    id="searchInput"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari mitra..."
                    class="search-input">

                <select id="websiteFilter" name="website" class="filter-select">
                    <option value="">Semua Website</option>
                    <option
                        value="ada"
                        {{ request('website') == 'ada' ? 'selected' : '' }}>
                        Ada Website
                    </option>
                    <option
                        value="tidak"
                        {{ request('website') == 'tidak' ? 'selected' : '' }}>
                        Tidak Ada Website
                    </option>
                </select>

                <select id="sortFilter" name="sort" class="filter-select">
                    <option value="display_order">Urutan Tampil</option>
                    <option value="nama_az">Nama A-Z</option>
                    <option value="nama_za">Nama Z-A</option>
                </select>

                <button
                    type="button"
                    id="refreshBtn"
                    class="btn-refresh">

                    <i class="fa-solid fa-rotate-right"></i>

                </button>

            </form>

            <div class="filter-right">
                <a href="{{ route('admin.partners.create') }}"
                    class="btn-tambah">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Mitra
                </a>
            </div>
        </section>

        <section class="table-section">

            <div class="table-responsive">

                <table class="table-admin mitra-table">

                    <thead>

                        <tr >

                            <th>No</th>

                            <th>Logo</th>

                            <th>Nama Mitra</th>

                            <th>Website</th>

                            <th>Urutan</th>

                            <th width="240">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($mitra as $item)
                            <tr 
                                data-name="{{ strtolower($item->name) }}"
                                data-website="{{ $item->website ? 'ada' : 'tidak' }}"
                                data-order="{{ $item->display_order }}">

                                <td>
                                    {{ $loop->iteration + ($mitra->firstItem() - 1) }}
                                </td>

                                <td>

                                    @if($item->logo)

                                        <img
                                            src="{{ asset('storage/'.$item->logo) }}"
                                            class="table-logo"
                                            alt="{{ $item->name }}">

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    <strong>{{ $item->name }}</strong>

                                </td>

                                <td>

                                    @if($item->website)

                                        <a
                                            href="{{ $item->website }}"
                                            target="_blank">

                                            {{ Str::limit($item->website,35) }}

                                        </a>

                                    @else

                                        <span class="text-muted">

                                            Tidak ada website

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $item->display_order }}

                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <button
                                            type="button"
                                            class="btn-detail"

                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal"

                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-description="{{ $item->description }}"
                                            data-order="{{ $item->display_order }}"
                                            data-logo="{{ $item->logo }}"
                                            data-website="{{ $item->website }}">

                                            <i class="fa-solid fa-eye"></i>

                                            {{-- Detail --}}

                                        </button>

                                        <a
                                            href="{{ route('admin.partners.edit',$item) }}"
                                            class="btn-edit">

                                            <i class="fa-solid fa-pen"></i>

                                            {{-- Edit --}}

                                        </a>

                                        <button
                                            type="button"
                                            class="btn-delete"

                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"

                                            onclick="confirmDelete(this)">

                                            <i class="fa-solid fa-trash"></i>

                                            {{-- Hapus --}}

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    Belum ada data mitra.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- ===== PAGINATION ===== -->
                <!-- ================= PAGINATION ================= -->

                    @if ($mitra->hasPages())

                        <div class="pagination-wrapper">

                            <nav>

                                <ul class="pagination">

                                    {{-- Previous --}}
                                    <li class="page-item {{ $mitra->onFirstPage() ? 'disabled' : '' }}">

                                        <a class="page-link"
                                            href="{{ $mitra->onFirstPage() ? '#' : $mitra->previousPageUrl() }}">

                                            <i class="fa-solid fa-chevron-left"></i>

                                        </a>

                                    </li>

                                    {{-- Nomor Halaman --}}
                                    @foreach ($mitra->getUrlRange(1, $mitra->lastPage()) as $page => $url)

                                        <li class="page-item {{ $page == $mitra->currentPage() ? 'active' : '' }}">

                                            <a class="page-link" href="{{ $url }}">

                                                {{ $page }}

                                            </a>

                                        </li>

                                    @endforeach

                                    {{-- Next --}}
                                    <li class="page-item {{ !$mitra->hasMorePages() ? 'disabled' : '' }}">

                                        <a class="page-link"
                                            href="{{ $mitra->hasMorePages() ? $mitra->nextPageUrl() : '#' }}">

                                            <i class="fa-solid fa-chevron-right"></i>

                                        </a>

                                    </li>

                                </ul>

                            </nav>

                        </div>

                    @endif

        </section>
    </main>
</div>

<!-- ===== MODAL DETAIL ===== -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailBody">
                <!-- Isi detail akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- ===== NOTIFIKASI ===== -->

<script> window.storageUrl = "{{ asset('storage') }}"; </script>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/admin/mitra.js') }}"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        icon: 'success',
        title: '{{ session("title") ?? "Berhasil!" }}',
        text: '{{ session("success") }}',
        confirmButtonColor: '#2563eb',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });

});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#dc2626'
    });

});
</script>
@endif

@endpush