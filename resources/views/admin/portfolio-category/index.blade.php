@extends('admin.layouts.app')

@section('title','Kategori Portofolio')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/portfolio-category/index.css') }}">
@endpush

<div class="content">
    {{-- HEADER --}}
    <header class="topbar">

        <div>
            <h1>Kategori Portofolio</h1>
            <p>Kelola kategori portofolio</p>
        </div>


        <a href="{{ route('admin.portfolio-categories.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i>
            Tambah Kategori
        </a>

    </header>
    {{-- FILTER --}}
    <form
        id="categoryFilterForm"
        method="GET"
        action="{{ route('admin.portfolio-categories.index') }}"
        class="filter-container">

        <input
            type="text"
            id="searchInput"
            name="search"
            class="search-input"
            placeholder="Cari kategori..."
            value="{{ request('search') }}">

        <select
            id="sortSelect"
            name="sort"
            class="filter-select">
            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>
                Terbaru
            </option>

            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                Terlama
            </option>

            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>
                Nama (A-Z)
            </option>

            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>
                Nama (Z-A)
            </option>
        </select>

    </form>

    {{-- TABLE KATEGORI PORTFOLIO --}}
    <div class="portfolio-category-table">
        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @forelse($categories as $category)

                    <tr
                        data-name="{{ strtolower($category->name) }}"
                        data-date="{{ $category->created_at->timestamp }}">

                        <td>
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $category->name }}
                        </td>

                        <td>
                            {{ $category->slug }}
                        </td>

                        <td>
                            {{ $category->created_at->format('d M Y') }}
                        </td>

                        <td>
                            <div class="portfolio-category-action">

                                {{-- Detail --}}
                                <button
                                    class="btn-action detail"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $category->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                {{-- Edit --}}
                                <a href="{{ route('admin.portfolio-categories.edit', $category->id) }}"
                                class="btn-action edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.portfolio-categories.destroy', $category->id) }}"
                                    method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>


                    {{-- MODAL DETAIL --}}

                    <div class="modal fade"
                        id="detailModal{{ $category->id }}"
                        tabindex="-1">


                        <div class="modal-dialog modal-dialog-centered">


                            <div class="modal-content">


                                <div class="modal-header">


                                    <h5 class="modal-title">
                                        Detail Kategori Portofolio
                                    </h5>


                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>


                                </div>



                                <div class="modal-body">


                                    <div class="detail-item">

                                        <label>
                                            Nama Kategori
                                        </label>

                                        <p>
                                            {{ $category->name }}
                                        </p>

                                    </div>



                                    <div class="detail-item">

                                        <label>
                                            Slug
                                        </label>

                                        <p>
                                            {{ $category->slug }}
                                        </p>

                                    </div>



                                    <div class="detail-item">

                                        <label>
                                            Dibuat
                                        </label>

                                        <p>
                                            {{ $category->created_at->format('d M Y H:i') }}
                                        </p>

                                    </div>



                                    <div class="detail-item">

                                        <label>
                                            Update Terakhir
                                        </label>

                                        <p>
                                            {{ $category->updated_at->format('d M Y H:i') }}
                                        </p>

                                    </div>


                                </div>


                                <div class="modal-footer">


                                    <button
                                        class="btn-close-modal"
                                        data-bs-dismiss="modal">

                                        Tutup

                                    </button>


                                </div>


                            </div>


                        </div>


                    </div>


                @empty


                    <tr>

                        <td colspan="5" class="empty-data">

                            Belum ada kategori portofolio

                        </td>

                    </tr>


                @endforelse



            </tbody>


        </table>

        <!-- ================= PAGINATION ================= -->

            <div class="custom-pagination">

                {{-- ==========================
                    SHOW ENTRIES
                ========================== --}}
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

                        <span>Kategori</span>

                    </form>

                </div>


                {{-- ==========================
                    INFO DATA
                ========================== --}}
                <div class="pagination-center">

                    <span>Menampilkan</span>

                    <strong>{{ $categories->firstItem() ?? 0 }}</strong>

                    <span>-</span>

                    <strong>{{ $categories->lastItem() ?? 0 }}</strong>

                    <span>dari</span>

                    <strong>{{ $categories->total() }}</strong>

                    <span>data</span>

                </div>


                {{-- ==========================
                    PAGINATION
                ========================== --}}
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


                    @php

                        $start = max($categories->currentPage() - 1, 1);

                        $end = min($start + 1, $categories->lastPage());

                        if($end - $start < 1){

                            $start = max($end - 1, 1);

                        }

                    @endphp


                    @for($page = $start; $page <= $end; $page++)

                        @if($page == $categories->currentPage())

                            <span class="page-number active">

                                {{ $page }}

                            </span>

                        @else

                            <a href="{{ $categories->url($page) }}"
                            class="page-number">

                                {{ $page }}

                            </a>

                        @endif

                    @endfor


                    {{-- Next --}}
                    @if($categories->hasMorePages())

                        <a href="{{ $categories->nextPageUrl() }}"
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

    </div>


</div>


@endsection

@push('scripts')
<script src="{{ asset('js/admin/portfolio_category.js') }}"></script>
@endpush
