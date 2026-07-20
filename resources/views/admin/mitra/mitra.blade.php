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
            <form method="GET" action="{{ route('admin.partners.index') }}" class="filter-form">

                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari mitra..." 
                    class="search-input">
                
                <select name="website" class="filter-select">
                    <option value="">Semua</option>
                    <option value="ada" {{ request('website') == 'ada' ? 'selected' : '' }}>Ada Website</option>
                    <option value="tidak" {{ request('website') == 'tidak' ? 'selected' : '' }}>Tanpa Website</option>
                </select>

                <select name="sort" class="filter-select">
                    <option value="display_order" {{ request('sort') == 'display_order' ? 'selected' : '' }}>
                        Urutan Tampil
                    </option>
                    <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>
                        Nama A-Z
                    </option>
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                </select>

                <button type="submit" 
                        class="btn-refresh" 
                        onclick="location.reload()">
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

                <table class="table-admin">

                    <thead>

                        <tr>

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

                            <tr>

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
                <div class="pagination-controls">
                    @if ($mitra->hasPages())
                        <nav aria-label="Pagination">
                            <ul class="pagination">

                                {{-- Previous --}}
                                @if ($mitra->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo; Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                        href="{{ $mitra->previousPageUrl() }}">
                                            &laquo; Previous
                                        </a>
                                    </li>
                                @endif

                                {{-- Nomor Halaman --}}
                                @foreach ($mitra->getUrlRange(1, $mitra->lastPage()) as $page => $url)
                                    @if ($page == $mitra->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                            href="{{ $url }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($mitra->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                        href="{{ $mitra->nextPageUrl() }}">
                                            Next &raquo;
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next &raquo;</span>
                                    </li>
                                @endif

                            </ul>
                        </nav>
                    @endif
                </div>
            
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

<!-- ===== MODAL HAPUS ===== -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus mitra <strong id="deleteName"></strong>?</p>
                <p class="text-muted small">Data akan dihapus secara permanen.</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
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


    window.mitraRoutes = {
        update: "{{ url('admin/partners.index') }}",
        destroy: "{{ url('admin/partners.index') }}"
    };

    window.storageUrl = "{{ asset('storage') }}";
</script>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/mitra.js') }}"></script>
@endpush