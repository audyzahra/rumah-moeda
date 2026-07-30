@extends('user.layouts.app')

@section('title', 'Berita')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/berita.css') }}">
@endpush

@section('content')

    <div class="berita-container">

        {{-- ===================== ALERT ===================== --}}

        @if ($errors->any())

            <div class="alert-danger">

                <ul>

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ===================== HEADER ===================== --}}

        <div class="berita-header">

            <div>

                <h1>Berita</h1>

                <p>
                    Kelola berita yang Anda buat.
                </p>

            </div>

            <a href="{{ route('user.news.create') }}" class="btn-tambah">
                <i class="fa-solid fa-plus"></i>
                Tambah Berita
            </a>

        </div>


        {{-- ===================== FILTER ===================== --}}

        <form method="GET" id="filterForm" class="filter-container">

    <input
        type="text"
        name="search"
        id="searchInput"
        class="search-input"
        placeholder="Cari Judul Berita..."
        value="{{ request('search') }}"
    >

    <select
        name="category"
        id="categoryFilter"
        class="filter-select"
    >

        <option value="">Semua Kategori</option>

        @foreach ($categories as $category)

            <option
                value="{{ $category->id }}"
                {{ request('category') == $category->id ? 'selected' : '' }}
            >
                {{ $category->name }}
            </option>

        @endforeach

    </select>

    <input
        type="hidden"
        name="per_page"
        value="{{ request('per_page', 5) }}"
    >

</form>


        {{-- ===================== TABEL BERITA ===================== --}}
        <div class="table-container">

            <table class="berita-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal Publish</th>
                        <th >Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($news as $index => $item)
                        <tr data-title="{{ strtolower($item->title) }}"
                            data-category="{{ $item->category_id }}">

                            <td>{{ $index + 1 }}</td>

                            

                            <td>
                                <div class="news-title">
                                    <strong>{{ $item->title }}</strong>
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                                    </p>
                                </div>
                            </td>

                            <td>
                                <span class="kategori">
                                    {{ $item->category->name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $item->author->name ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->publish_date)->format('d M Y') }}
                            </td>

                            <td>
                                <div class="table-actions">

                                    <button
                                        class="btn-detail"
                                        onclick='showDetail({
                                            id: {{ $item->id }},
                                            title: @json($item->title),
                                            content: @json($item->content),
                                            thumbnail: @json($item->thumbnail ? Storage::url($item->thumbnail) : asset("assets/no-image.png")),
                                            category: @json($item->category->name ?? "-"),
                                            author: @json($item->author->name ?? "-"),
                                            publish_date: @json(\Carbon\Carbon::parse($item->publish_date)->format("d M Y H:i"))
                                        })'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <a href="{{ route('user.news.edit', $item->id) }}"
                                    class="btn-edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <button
                                        class="btn-delete"
                                        onclick="deleteBerita({{ $item->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fa-solid fa-newspaper"></i>
                                <h3>Belum ada berita</h3>
                                <p>Silakan tambahkan berita pertama.</p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            <!-- ================= PAGINATION ================= -->

                <!-- ================= PAGINATION ================= -->

            <div class="custom-pagination">

                {{-- Show Entries --}}
                <div class="pagination-left">

                    <form method="GET">

    <input type="hidden" name="search" value="{{ request('search') }}">
    <input type="hidden" name="category" value="{{ request('category') }}">

                        @foreach(request()->except('per_page','page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <span>Tampilkan</span>

                        <select name="per_page" onchange="this.form.submit()">

                            <option value="5" {{ request('per_page',5)==5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>50</option>

                        </select>

                        <span>berita</span>

                    </form>

                </div>

                {{-- Info --}}
                <div class="pagination-center">

                    <span>Menampilkan</span>

                    <strong>{{ $news->firstItem() ?? 0 }}</strong>

                    <span>-</span>

                    <strong>{{ $news->lastItem() ?? 0 }}</strong>

                    <span>dari</span>

                    <strong>{{ $news->total() }}</strong>

                    <span>data</span>

                </div>

                {{-- Pagination --}}
                <div class="pagination-right">

                    @if ($news->onFirstPage())

                        <button class="page-btn" disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                    @else

                        <a href="{{ $news->appends(request()->query())->previousPageUrl() }}" class="page-btn">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                    @endif

                    @foreach ($news->appends(request()->query())->getUrlRange(1, $news->lastPage()) as $page => $url)

                        @if ($page == $news->currentPage())

                            <span class="page-number active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $url }}" class="page-number">
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach

                    @if ($news->hasMorePages())

                        <a href="{{ $news->appends(request()->query())->nextPageUrl() }}" class="page-btn">
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

        {{-- ===========================
            MODAL DETAIL
    ============================ --}}

        <div class="modal" id="detailModal">

            <div class="modal-content modal-large">

                <div class="modal-header">

                    <h2>Detail Berita</h2>

                    <button type="button" class="modal-close" onclick="closeDetailModal()">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="detail-image">

                        <img id="detailThumbnail" src="" alt="Thumbnail">

                    </div>

                    <div class="detail-content">

                        <span class="badge-category" id="detailCategory">

                        </span>

                        <h2 id="detailTitle"></h2>

                        <div class="detail-meta">

                            <span>

                                <i class="fa-solid fa-user"></i>

                                <span id="detailAuthor"></span>

                            </span>

                            <span>

                                <i class="fa-solid fa-calendar"></i>

                                <span id="detailDate"></span>

                            </span>

                        </div>

                        <hr>

                        <div class="detail-text" id="detailContent">

                        </div>

                    </div>

                </div>

            </div>

        </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endsection

    @push('scripts')
        {{-- Tetap memakai JS Admin --}}
        <script src="{{ asset('js/admin/berita.js') }}"></script>
    @endpush
