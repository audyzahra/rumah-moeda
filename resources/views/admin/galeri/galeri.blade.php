@extends('admin.layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
    @endpush

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="content">

        <header class="topbar">
            <div>
                <h1>Manajemen Dokumentasi</h1>
                <p>Kelola foto-foto dokumentasi kegiatan</p>
            </div>
        </header>

        <form method="GET" class="filter-section">

            <div class="filter-left">

                <input type="text" id="searchInput" class="search-input" placeholder="Cari dokumentasi...">

                <select name="sort" class="filter-select" onchange="this.form.submit()">

                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                        Terbaru
                    </option>

                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        Terlama
                    </option>

                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                        Judul A-Z
                    </option>

                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                        Judul Z-A
                    </option>

                </select>

            </div>

            <div class="filter-right">

                <a href="{{ route('admin.gallery.create') }}" class="btn-tambah">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Galeri
                </a>

                <button type="button" class="btn-refresh" onclick="location.reload()">

                    <i class="fa-solid fa-rotate-right"></i>

                </button>

            </div>

        </form>

        <section class="table-section">

            <div class="table-wrapper">

                <table class="gallery-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Penulis</th>
                            <th>Jumlah Media</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse($galleries as $gallery)
                            @php
                                $thumbnail = $gallery->media->first();
                            @endphp


                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>



                                <td>

                                    @if ($thumbnail)
                                        @if ($thumbnail->type == 'image')
                                            <img src="{{ asset('storage/' . $thumbnail->file_path) }}"
                                                class="table-thumbnail">
                                        @else
                                            <img src="https://img.youtube.com/vi/{{ $thumbnail->youtube_id }}/hqdefault.jpg"
                                                class="table-thumbnail">
                                        @endif
                                    @else
                                        <span>Tidak ada</span>
                                    @endif

                                </td>




                                <td>
                                    <strong>
                                        {{ $gallery->title }}
                                    </strong>
                                </td>



                                <td>
                                    {{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}
                                </td>



                                <td>
                                    {{ Str::limit(strip_tags($gallery->description, 80)) }}
                                </td>

                                <td>
                                    {{ $gallery->author?->name ?? '-' }}
                                </td>


                                <td>
                                    {{ $gallery->media->count() }} Media
                                </td>


                                <td>
                                    <div class="action-column">

                                        <!-- Detail -->
                                        <button type="button" class="action-btn detail" data-title="{{ $gallery->title }}"
                                            data-date="{{ \Carbon\Carbon::parse($gallery->activity_date)->format('d M Y') }}"
                                            data-description="{{ $gallery->description }}"
                                            data-media='@json($gallery->media)' onclick="showDetail(this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="action-btn edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>


                        @empty

                            <tr>
                                <td colspan="8" class="empty-table">
                                    Belum ada dokumentasi
                                </td>
                            </tr>
                        @endforelse


                    </tbody>

                </table>


            </div>


            <div class="mt-4">
                {{ $galleries->links() }}
            </div>


        </section>
    </div>



    <!-- Modal Detail -->
    <div id="detailModal" class="modal" style="display:none;">

        <div class="modal-content modal-large">

            <div class="modal-header">
                <h2>Detail Galeri</h2>

                <button type="button" class="close-modal" onclick="closeDetailModal()">
                    &times;
                </button>
            </div>

            <div class="modal-body">

                <div class="detail-image">

                    <div id="detail_media"></div>

                </div>

                <div class="detail-content">

                    <div class="detail-item">
                        <label>Judul</label>
                        <p id="detail_title"></p>
                    </div>

                    <div class="detail-item">
                        <label>Tanggal Kegiatan</label>
                        <p id="detail_date"></p>
                    </div>

                    <div class="detail-item">
                        <label>Deskripsi</label>
                        <p id="detail_description"></p>
                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush
