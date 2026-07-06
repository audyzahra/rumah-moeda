@extends('Layouts.app')

@section('title', 'Berita')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('content')

    <div class="berita-header">

        <div>

            <h1>Berita Rumah Moeda</h1>

            <p>
                Informasi terbaru mengenai kegiatan Rumah Moeda.
            </p>

        </div>

        <button class="btn-tambah" id="openModal">
            <i class="fa-solid fa-plus"></i>
            Tambah Berita
        </button>

    </div>


    <section class="berita-list">

        @forelse($news as $item)
            <div class="berita-card">

                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->title }}">

                <div class="berita-content">

                    <div class="meta">

                        <span>

                            <i class="fa-solid fa-tag"></i>

                            {{ $item->category->name }}

                        </span>

                        <span>

                            <i class="fa-regular fa-calendar"></i>

                            {{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('d F Y') }}

                        </span>

                    </div>

                    <h2>

                        {{ $item->title }}

                    </h2>

                    <p>

                        {{ Str::limit(strip_tags($item->content), 220) }}

                    </p>

                    <div class="action">

                        <a href="{{ route('berita.show', $item->slug) }}">

                            Baca Selengkapnya →

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div style="text-align:center;padding:60px;">

                <h3>Belum ada berita.</h3>

            </div>
        @endforelse

    </section>

    <!-- Modal Tambah Berita -->
    <div class="modal" id="beritaModal">

        <div class="modal-content">

            <span class="close" id="closeModal">&times;</span>

            <h2>Tambah Berita</h2>

            <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="form-group">

                    <label>Judul Berita</label>

                    <input type="text" name="title" class="form-control" required>

                </div>

                <div class="form-group">

                    <div class="form-group">

                        <label>Kategori Berita</label>

                        <select name="category_id" class="form-control" required>

                            <option value="">-- Pilih Kategori --</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <label>Foto Berita</label>

                    <input type="file" name="thumbnail" accept="image/*" required>

                </div>

                <div class="form-group">

                    <label>Isi Berita</label>

                    <textarea rows="6" name="content" required></textarea>

                </div>

                <div class="form-group">

                    <label>Tanggal Publish</label>

                    <input type="date" name="publish_date" required>

                </div>

                <button type="submit" class="btn-simpan">

                    Simpan Berita

                </button>

            </form>

        </div>

    </div>

    <script>
        const modal = document.getElementById("beritaModal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");

        openModal.onclick = function() {
            modal.classList.add("show");
        }

        closeModal.onclick = function() {
            modal.classList.remove("show");
        }

        window.onclick = function(e) {
            if (e.target == modal) {
                modal.classList.remove("show");
            }
        }
    </script>

@endsection
