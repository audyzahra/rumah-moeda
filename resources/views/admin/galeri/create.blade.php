@extends('admin.layouts.app')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
@endpush

<div class="content">

    <header class="topbar">

        <div>

            <h1>Tambah Galeri</h1>

            <p>Tambah dokumentasi kegiatan</p>

            <a href="{{ route('admin.gallery.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>

        </div>

    </header>

    <div class="gallery-container">
        <div class="form-card">

            <form action="{{ route('admin.gallery.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="activity_date" class="form-control" required>
                </div>

                <div class="form-group">

                    <label>
                        Deskripsi
                        <span class="required">*</span>
                    </label>

                    <x-tiptap
                        name="description"
                        :value="old('description')"
                        placeholder="Masukkan deskripsi kegiatan..."
                        :image="false" />

                    @error('description')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror

                </div>

                <div id="photo-container">

                    <div class="form-group">

                        <label>Foto</label>

                        <input
                            type="file"
                            name="images[]"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">

                    </div>

                </div>

                <button
                    type="button"
                    id="btn-add-photo"
                    class="btn btn-secondary">

                    + Tambah Foto

                </button>

                <div id="video-container">

                    <div class="form-group">

                        <label>Video YouTube</label>

                        <input
                            type="url"
                            name="videos[]"
                            class="form-control"
                            placeholder="https://www.youtube.com/watch?v=xxxx">

                        <small class="text-muted">
                            Tambahkan satu atau lebih link video YouTube (opsional).
                        </small>

                    </div>

                </div>

                <button
                    type="button"
                    id="btn-add-video"
                    class="btn btn-secondary">

                    + Tambah Link Video

                </button>

                <div class="modal-footer">

                    <a href="{{ route('admin.gallery.index') }}"
                        class="btn-batal">

                        Batal

                    </a>

                    <button class="btn-simpan">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/galeri.js') }}"></script>
@endpush

