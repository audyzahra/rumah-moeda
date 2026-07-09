@extends('admin.layouts.app')

@section('title', 'Berita')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/berita.css') }}">
@endpush

@section('content')

    <div class="berita-container">

        {{-- ===================== ALERT ===================== --}}

        @if(session('success'))
    <div id="notification" class="notification success show">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

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
                    Kelola seluruh berita dan artikel Rumah Moeda.
                </p>

            </div>

            <button class="btn-tambah" onclick="openTambahModal()">

                <i class="fa-solid fa-plus"></i>

                Tambah Berita

            </button>

        </div>


        {{-- ===================== STATISTIK ===================== --}}

        <div class="berita-stats">

            {{-- Total Berita --}}
            <div class="stat-card">

                <div class="stat-icon total">
                    <i class="fa-solid fa-newspaper"></i>
                </div>

                <div class="stat-info">
                    <h4>Total Berita</h4>
                    <h2>{{ $news->count() }}</h2>
                </div>

            </div>

            {{-- Total Kategori --}}
            <div class="stat-card">

                <div class="stat-icon categories">
                    <i class="fa-solid fa-folder-open"></i>
                </div>

                <div class="stat-info">
                    <h4>Total Kategori</h4>
                    <h2>{{ $categories->count() }}</h2>
                </div>

            </div>

        </div>



        {{-- ===================== FILTER ===================== --}}

        <div class="filter-container">

            <input type="text" id="searchInput" placeholder="Cari Judul Berita..." class="search-input">

            <select id="categoryFilter" class="filter-select">

                <option value="">Semua Kategori</option>

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
                <div class="berita-card" data-title="{{ strtolower($item->title) }}">
                    <div class="berita-image">

                        @if ($item->thumbnail)
                            <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->title }}">
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

                            <button class="btn-detail"
                                onclick='showDetail({
                                    id: {{ $item->id }},
                                    title: @json($item->title),
                                    content: @json($item->content),
                                    thumbnail: @json($item->thumbnail),
                                    author: @json($item->author->name),
                                    publish_date: @json(\Carbon\Carbon::parse($item->publish_date)->format('d M Y H:i'))
                                })'>

                                <i class="fa-solid fa-eye"></i>

                            </button>

                            <button class="btn-edit" onclick='editBerita(@json($item))'>

                                <i class="fa-solid fa-pen"></i>

                            </button>

                            <button class="btn-delete" onclick="deleteBerita({{ $item->id }})">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-state">

                    <i class="fa-solid fa-newspaper"></i>

                    <h3>Belum ada berita</h3>

                    <p>

                        Silakan tambahkan berita pertama.

                    </p>

                </div>
            @endforelse

        </div>
        {{-- ===========================
            MODAL TAMBAH / EDIT
    ============================ --}}

        <div class="modal" id="formModal">

            <div class="modal-content modal-large">

                <div class="modal-header">

                    <h2 id="formModalTitle">
                        Tambah Berita
                    </h2>

                    <button type="button" class="modal-close" onclick="closeFormModal()">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <form id="beritaForm" action="{{ route('admin.berita.store') }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    {{-- ID Berita (untuk Edit) --}}
                    <input type="hidden" id="berita_id" name="berita_id">

                    <div class="modal-body">

                        {{-- Judul --}}
                        <div class="form-group">

                            <label for="title">
                                Judul Berita
                                <span class="required">*</span>
                            </label>

                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Masukkan judul berita" required>

                        </div>

                        {{-- Kategori --}}
                        <div class="form-group">

                            <label for="category_id">
                                Kategori
                                <span class="required">*</span>
                            </label>

                            <select id="category_id" name="category_id" class="form-control" required>

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Thumbnail --}}
                        <div class="form-group">

                            <label for="thumbnail">

                                Thumbnail

                                <span class="required">*</span>

                            </label>

                            <input type="file" id="thumbnail" name="thumbnail" class="form-control"
                                accept=".jpg,.jpeg,.png" onchange="previewImage(event)">

                            <small class="text-muted">
                                Format yang diperbolehkan :
                                JPG, JPEG, PNG
                                (Maksimal 2 MB)
                            </small>

                            <div class="image-preview">

                                <img id="preview" src="" alt="Preview Thumbnail"
                                    style="display:none; width:100%; max-height:250px; object-fit:cover; border-radius:8px; margin-top:15px;">

                            </div>

                        </div>

                        {{-- Isi Berita --}}
                        <div class="form-group">

                            <label for="content">

                                Isi Berita

                                <span class="required">*</span>

                            </label>

                            <textarea id="content" name="content" class="form-control" rows="8" placeholder="Masukkan isi berita..."
                                required></textarea>

                        </div>

                        {{-- Publish Date --}}
                        <div class="form-group">

                            <label for="publish_date">

                                Tanggal Publish

                                <span class="required">*</span>

                            </label>

                            <input type="datetime-local" id="publish_date" name="publish_date" class="form-control"
                                step="1" required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn-batal" onclick="closeFormModal()">

                            <i class="fa-solid fa-xmark"></i>

                            Batal

                        </button>

                        <button id="submitButton" type="submit" class="btn-simpan">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan Berita

                        </button>

                    </div>

                </form>

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



        {{-- ===========================
            MODAL HAPUS
    ============================ --}}

        <div class="modal" id="deleteModal">

            <div class="modal-content modal-delete">

                <div class="modal-header">

                    <h2>Hapus Berita</h2>

                    <button type="button" class="modal-close" onclick="closeDeleteModal()">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <div class="modal-body text-center">

                    <div class="delete-icon">

                        <i class="fa-solid fa-trash-can"></i>

                    </div>

                    <h3>

                        Apakah Anda yakin?

                    </h3>

                    <p>

                        Berita yang dihapus tidak dapat dikembalikan lagi.

                    </p>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn-bataldary" onclick="closeDeleteModal()">

                        Batal

                    </button>

                    <form id="deleteForm" method="POST">

                        @csrf

                        @method('DELETE')

                        <button type="submit" class="btn-delete">

                            <i class="fa-solid fa-trash"></i>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>



        {{-- ===========================
            NOTIFICATION
    ============================ --}}

        <div id="notification" class="notification">

        </div>
        {{-- ===========================
        SCRIPT LARAVEL
=========================== --}}

    @endsection

    @push('scripts')
        <script src="{{ asset('js/admin/berita.js') }}"></script>
    @endpush
