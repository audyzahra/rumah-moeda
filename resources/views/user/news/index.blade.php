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

        <div class="filter-container">

            <input type="text" id="searchInput" placeholder="Cari Judul Berita..." class="search-input">

            <select id="categoryFilter" class="filter-select">

                <option value="">
                    Semua Kategori
                </option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">

                        {{ $category->name }}

                    </option>
                @endforeach

            </select>

        </div>


        {{-- ===================== GRID BERITA ===================== --}}

        <div class="berita-grid">

            @forelse($news as $item)
                <div class="berita-card" data-title="{{ strtolower($item->title) }}"
                    data-category="{{ $item->category_id }}">
                    <div class="berita-image">

                        @if ($item->thumbnail)
                            <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}">
                        @else
                            <img src="{{ asset('assets/no-image.png') }}" alt="No Image">
                        @endif

                    </div>

                    <div class="berita-content">

                        <span class="kategori">

                            {{ $item->category->name ?? '-' }}

                        </span>

                        <h3>

                            {{ $item->title }}

                        </h3>

                        <p>

                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}

                        </p>

                        <div class="berita-info">

                            <span>

                                <i class="fa-solid fa-user"></i>

                                {{ $item->author->name ?? '-' }}

                            </span>

                            <span>

                                <i class="fa-solid fa-calendar"></i>

                                {{ \Carbon\Carbon::parse($item->publish_date)->format('d M Y') }}

                            </span>

                        </div>

                        <div class="card-actions">

                            {{-- DETAIL --}}
                            <button class="btn-detail"
                                onclick='showDetail({

                                id: {{ $item->id }},

                                title: @json($item->title),

                                content: @json($item->content),

                                thumbnail: @json($item->thumbnail ? Storage::url($item->thumbnail) : asset('assets/no-image.png')),

                                category: @json($item->category->name ?? '-'),

                                author: @json($item->author->name ?? '-'),

                                publish_date: @json(\Carbon\Carbon::parse($item->publish_date)->format('d M Y H:i'))

                            })'>

                                <i class="fa-solid fa-eye"></i>

                            </button>


                            {{-- EDIT --}}
                            <a href="{{ route('user.news.edit', $item->id) }}" class="btn-edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>


                            {{-- DELETE --}}
                            <button class="btn-delete" onclick="deleteBerita({{ $item->id }})">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-state">

                    <i class="fa-solid fa-newspaper"></i>

                    <h3>

                        Belum ada berita

                    </h3>

                    <p>

                        Silakan tambahkan berita pertama Anda.

                    </p>

                </div>
            @endforelse

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
