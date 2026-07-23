@extends('user.layouts.app')

@section('title', 'Tambah Galeri')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
@endpush

@section('content')

    <div class="gallery-container">

        {{-- ================= HEADER ================= --}}
        <div class="gallery-header">

    <div class="gallery-title">
        <h1>Tambah Galeri</h1>
        <p>Tambahkan dokumentasi kegiatan Rumah Moeda.</p>
    </div>

    <a href="{{ route('user.gallery.index') }}" class="btn-batal">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>
</div>

        {{-- ================= FORM ================= --}}
        <div class="form-card">

            <form action="{{ route('user.gallery.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                {{-- ================= JUDUL ================= --}}
                <div class="form-group">

                    <label>

                        Judul Dokumentasi

                        <span class="required">*</span>

                    </label>

                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Masukkan judul dokumentasi">

                    @error('title')
                        <small class="text-danger">

                            {{ $message }}

            
                        </small>
                    @enderror

                </div>

                {{-- ================= TANGGAL ================= --}}
                <div class="form-group">

                    <label>

                        Tanggal Kegiatan

                        <span class="required">*</span>

                    </label>

                    <input type="date" name="activity_date"
                        class="form-control @error('activity_date') is-invalid @enderror"
                        value="{{ old('activity_date') }}">

                    @error('activity_date')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                </div>

                {{-- ================= DESKRIPSI ================= --}}
                <div class="form-group">

                    <label>

                        Deskripsi

                        <span class="required">*</span>

                    </label>

                    <x-tiptap name="description" :value="old('description')" placeholder="Masukkan deskripsi kegiatan..."
                        :image="false" />

                    @error('description')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                </div>
                        {{-- ================= FOTO ================= --}}
<div class="form-group">

    <label>
        Upload Foto
        <span class="required">*</span>
    </label>

    <div id="photoContainer">

        <div class="photo-input">

            <input
                type="file"
                name="photos[]"
                class="form-control"
                accept="image/*">

        </div>

    </div>

    <button
        type="button"
        class="btn-secondary"
        id="btnTambahFoto">

        <i class="fa-solid fa-plus"></i>
        Tambah Foto

    </button>

    <small class="text-muted">
        Format JPG, JPEG, PNG. Maksimal 2 MB per file.
    </small>

    @error('photos')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    @error('photos.*')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    <div
        id="photoPreview"
        class="preview-grid">

    </div>

</div>

                {{-- ================= VIDEO ================= --}}
                <div class="form-group">

                    <label>

                        Link Video YouTube

                    </label>

                    <div id="videoContainer">

                        <div class="video-input">

                            <input type="url" name="videos[]" class="form-control"
                                placeholder="https://www.youtube.com/watch?v=...">

                        </div>

                    </div>

                    <button type="button" class="btn-secondary" id="btnTambahVideo">

                        <i class="fa-solid fa-plus"></i>

                        Tambah Link Video

                    </button>

                </div>

                {{-- ================= FOOTER ================= --}}
                <div class="form-footer">

                    <a href="{{ route('user.gallery.index') }}" class="btn-batal">

                        <i class="fa-solid fa-xmark"></i>

                        Batal

                    </a>

                    <button type="submit" class="btn-simpan">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Dokumentasi

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const photoContainer = document.getElementById('photoContainer');
    const photoPreview = document.getElementById('photoPreview');

    // ================= PREVIEW FOTO =================
    function previewPhotos() {
        photoPreview.innerHTML = '';

        document.querySelectorAll('#photoContainer input[type="file"]').forEach(input => {

            Array.from(input.files).forEach(file => {

                const reader = new FileReader();

                reader.onload = function (e) {

                    photoPreview.innerHTML += `
                        <div class="preview-item">
                            <img src="${e.target.result}">
                        </div>
                    `;

                };

                reader.readAsDataURL(file);

            });

        });
    }

    // Preview ketika memilih foto
    document.addEventListener('change', function (e) {

        if (e.target.matches('#photoContainer input[type="file"]')) {
            previewPhotos();
        }

    });

    // ================= TAMBAH FOTO =================
    document.getElementById('btnTambahFoto').addEventListener('click', function () {

        photoContainer.insertAdjacentHTML('beforeend', `
            <div class="photo-input" style="display:flex;gap:10px;margin-top:10px;align-items:center;">

                <input
                    type="file"
                    name="photos[]"
                    class="form-control"
                    accept="image/*">

                <button
                    type="button"
                    class="btn-delete remove-photo">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `);

    });

    // ================= TAMBAH VIDEO =================
    document.getElementById('btnTambahVideo').addEventListener('click', function () {

        document.getElementById('videoContainer').insertAdjacentHTML('beforeend', `
            <div class="video-input" style="display:flex;gap:10px;margin-top:10px;align-items:center;">

                <input
                    type="url"
                    name="videos[]"
                    class="form-control"
                    placeholder="https://www.youtube.com/watch?v=...">

                <button
                    type="button"
                    class="btn-delete remove-video">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `);

    });

    // ================= HAPUS FOTO / VIDEO =================
    document.addEventListener('click', function (e) {

        if (e.target.closest('.remove-photo')) {

            e.target.closest('.photo-input').remove();
            previewPhotos();

        }

        if (e.target.closest('.remove-video')) {

            e.target.closest('.video-input').remove();

        }

    });

});
</script>
@endpush