@extends('admin.layouts.app')

@section('title', 'Kategori Berita')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kategori.css') }}">
@endpush

@section('content')

    <div class="kategori-container">

        {{-- ================= HEADER ================= --}}
        <div class="kategori-header">

            <div>

                <h1>Kategori Berita</h1>

                <p>Kelola kategori berita Rumah Moeda.</p>

            </div>

        </div>


        {{-- ================= TOOLBAR ================= --}}
        <div class="kategori-toolbar">

            <form action="{{ route('admin.categories.index') }}" method="GET" class="search-form" id="filterForm">

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    class="search-input"
                    placeholder="Cari kategori..."
                    value="{{ request('search') }}">
            </form>

            <a href="{{ route('admin.categories.create') }}" class="btn-primary">

                <i class="fa-solid fa-plus"></i>

                Tambah Kategori

            </a>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="table-wrapper">

            <table class="kategori-table">

                <thead>

                    <tr>

                        <th width="70">No</th>

                        <th>Nama Kategori</th>

                        <th width="170">Jumlah Berita</th>

                        <th width="220">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)
                        <tr>

                            <td>

                                {{ $categories->firstItem() + $loop->index }}

                            </td>

                            <td>

                                {{ $category->name }}

                            </td>

                            <td>

                                <span class="badge-news">

                                    {{ $category->news_count }}

                                </span>

                            </td>

                            <td>

                                <div class="action-group">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn-detail">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <button
                                        type="button"
                                        class="btn-delete"
                                        onclick="deleteKategori({{ $category->id }})">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-state">

                                    <i class="fa-solid fa-folder-open"></i>

                                    <h3>

                                        Belum ada kategori

                                    </h3>

                                    <p>

                                        Tambahkan kategori pertama.

                                    </p>

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{--===PAGINATOIN=== --}}
            <div class="custom-pagination">

                {{-- ==========================================
                    SHOW ENTRIES
                ========================================== --}}
                <div class="pagination-left">

                    <form method="GET" id="perPageForm">

                        {{-- Pertahankan query search & sort --}}
                        @foreach(request()->except('per_page', 'page') as $key => $value)

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

                        <span>Kategori</span>

                    </form>

                </div>


                {{-- ==========================================
                    INFO DATA
                ========================================== --}}
                <div class="pagination-center">

                    <span>Menampilkan</span>

                    <strong>{{ $categories->firstItem() ?? 0 }}</strong>

                    <span>-</span>

                    <strong>{{ $categories->lastItem() ?? 0 }}</strong>

                    <span>dari</span>

                    <strong>{{ $categories->total() }}</strong>

                    <span>data</span>

                </div>


                {{-- ==========================================
                    PAGINATION
                ========================================== --}}
                <div class="pagination-right">

                    {{-- Previous --}}
                    @if($categories->onFirstPage())

                        <button class="page-btn" disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                    @else

                        <a href="{{ $categories->previousPageUrl() }}" class="page-btn">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                    @endif


                    {{-- Nomor Halaman --}}
                    @php
                        $start = max($categories->currentPage() - 1, 1);
                        $end = min($start + 1, $categories->lastPage());

                        if ($end - $start < 1) {
                            $start = max($end - 1, 1);
                        }
                    @endphp

                    @for($page = $start; $page <= $end; $page++)

                        @if($page == $categories->currentPage())

                            <span class="page-number active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $categories->url($page) }}" class="page-number">
                                {{ $page }}
                            </a>

                        @endif

                    @endfor


                    {{-- Next --}}
                    @if($categories->hasMorePages())

                        <a href="{{ $categories->nextPageUrl() }}" class="page-btn">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>

                    @else

                        <button class="page-btn" disabled>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                    @endif

                </div>

            </div>

        </div>
    </div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
window.categorySuccess = {
    title: @json(session('title') ?? 'Berhasil!'),
    text: @json(session('success'))
};
</script>
@endif

@if(session('error'))
<script>
window.categoryError = @json(session('error'));
</script>
@endif

<script src="{{ asset('js/admin/kategori.js') }}"></script>

@endpush
