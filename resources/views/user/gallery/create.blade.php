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

        <form
            action="{{ route('user.gallery.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            {{-- ================= JUDUL ================= --}}
            <div class="form-group">

                <label>

                    Judul Dokumentasi

                    <span class="required">*</span>

                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
                    placeholder="Masukkan judul dokumentasi">

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

                <input
                    type="date"
                    name="activity_date"
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

                <textarea
                    name="description"
                    rows="6"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Masukkan deskripsi kegiatan...">{{ old('description') }}</textarea>

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

                        <input
                            type="url"
                            name="videos[]"
                            class="form-control"
                            placeholder="https://www.youtube.com/watch?v=...">

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-secondary"
                    id="btnTambahVideo">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Link Video

                </button>

            </div>

            {{-- ================= FOOTER ================= --}}
            <div class="form-footer">

                <a
                    href="{{ route('user.gallery.index') }}"
                    class="btn-batal">

                    <i class="fa-solid fa-xmark"></i>

                    Batal

                </a>

                <button
                    type="submit"
                    class="btn-simpan">

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

function previewPhotos() {

    const preview = document.getElementById('photoPreview');

    preview.innerHTML = '';

    document.querySelectorAll('#photoContainer input[type="file"]').forEach(input => {

        Array.from(input.files).forEach(file => {

            const reader = new FileReader();

            reader.onload = function(e){

                preview.innerHTML += `
                    <div class="preview-item">
                        <img src="${e.target.result}">
                    </div>
                `;

            };

            reader.readAsDataURL(file);

        });

    });

}

document.addEventListener('change', function(e){

    if(e.target.matches('#photoContainer input[type="file"]')){

        previewPhotos();

    }

});

document.getElementById('btnTambahFoto').addEventListener('click', function(){

    const container = document.getElementById('photoContainer');

    container.insertAdjacentHTML('beforeend', `

        <div class="photo-input" style="display:flex;gap:10px;margin-top:10px;">

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

document.addEventListener('click', function(e){

    if(e.target.closest('.remove-photo')){

        e.target.closest('.photo-input').remove();

        previewPhotos();

    }

    if(e.target.closest('.remove-video')){

        e.target.closest('.video-input').remove();

    }

});

document.getElementById('btnTambahVideo').addEventListener('click', function () {

    const container = document.getElementById('videoContainer');

    container.insertAdjacentHTML('beforeend', `

        <div class="video-input" style="margin-top:10px;display:flex;gap:10px;">

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

document.addEventListener('click', function(e){

    if(e.target.closest('.remove-video')){

        e.target.closest('.video-input').remove();

    }

});

</script>

@endpush
