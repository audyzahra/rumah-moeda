@extends('admin.layouts.app')

@section('title', 'Tambah Galeri')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
    @endpush

    <div class="content">

        <header class="topbar">

            <div>

                <h1>Tambah Galeri</h1>

                <p>Tambah dokumentasi kegiatan</p>

            </div>

        </header>
        <!-- ================= BREADCRUMB ================= -->

        <div class="page-breadcrumb">

            <a href="{{ route('admin.gallery.index') }}">

                Galeri

            </a>

            <span>></span>

            <span>Tambah Galeri</span>

        </div>

        <div class="gallery-container">
            <div class="form-card">

                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="activity_date" class="form-control" value="{{ old('activity_date') }}"
                            required>
                    </div>

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

                    <div id="photo-container">

                        <div class="form-group photo-item">

                            <label>
                                Foto
                                <span class="required">*</span>
                            </label>

                            <div class="input-with-action">

                                <input type="file" name="images[]"
                                    class="form-control @error('images') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp">

                            </div>
                            @error('images')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                            <small class="text-muted">
                                Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB per file.
                            </small>

                        </div>

                    </div>

                    <button type="button" id="btn-add-photo" class="btn btn-secondary">

                        + Tambah Foto

                    </button>

                    <div id="video-container">

                        <div class="form-group video-item">

                            <label>
                                Video YouTube
                                <span class="text-muted">(Opsional)</span>
                            </label>

                            <div class="input-with-action">

                                <input type="url" name="videos[]" class="form-control"
                                    placeholder="https://www.youtube.com/watch?v=xxxx">

                            </div>

                            <small class="text-muted">
                                Tambahkan satu atau lebih link video YouTube (opsional).
                            </small>

                        </div>

                    </div>

                    <button type="button" id="btn-add-video" class="btn btn-secondary">

                        + Tambah Link Video

                    </button>

                    <div class="modal-footer">

                        <a href="{{ route('admin.gallery.index') }}" class="btn-batal">
                            <i class="fa-solid fa-xmark"></i>

                            Batal

                        </a>

                        <button class="btn-simpan">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Galeri
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Input Ditolak',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626',
    });
});
</script>
@endif

@push('scripts')
    <script src="{{ asset('js/admin/galeri.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.querySelector("form");

            form.addEventListener("submit", function(e) {

                const photoInputs = document.querySelectorAll('input[name="images[]"]');

                let hasPhoto = false;

                photoInputs.forEach(input => {
                    if (input.files.length > 0) {
                        hasPhoto = true;
                    }
                });

                if (!hasPhoto) {

                    e.preventDefault();

                    Swal.fire({
                        icon: "warning",
                        title: "Foto wajib diisi",
                        text: "Minimal harus menambahkan 1 foto sebelum galeri disimpan.",
                        confirmButtonColor: "#D4AF37",
                        confirmButtonText: "Mengerti"
                    });

                    return;
                }

            });

        });
    </script>
@endpush
@push('scripts')
    <script src="{{ asset('js/admin/galeri.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.querySelector("form");

            form.addEventListener("submit", function(e) {

                const photoInputs = document.querySelectorAll('input[name="images[]"]');

                let hasPhoto = false;

                photoInputs.forEach(input => {
                    if (input.files.length > 0) {
                        hasPhoto = true;
                    }
                });

                if (!hasPhoto) {

                    e.preventDefault();

                    Swal.fire({
                        icon: "warning",
                        title: "Foto wajib diisi",
                        text: "Minimal harus menambahkan 1 foto sebelum galeri disimpan.",
                        confirmButtonColor: "#D4AF37",
                        confirmButtonText: "Mengerti"
                    });

                    return;
                }

            });

        });
    </script>
@endpush
