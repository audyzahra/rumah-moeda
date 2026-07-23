@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
@endpush

<div class="content">

    <header class="topbar">

        <div>

            <h1>Edit Galeri</h1>

            <p>Ubah dokumentasi kegiatan</p>

        </div>

    </header>
     <!-- ================= BREADCRUMB ================= -->

            <div class="page-breadcrumb">

                <a href="{{ route('admin.gallery.index') }}">

                    Galeri

                </a>

                <span>></span>

                <span>Edit Galeri</span>

            </div>

    <div class="gallery-container">

        <div class="form-card">

            <form
                action="{{ route('admin.gallery.update', $gallery->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $gallery->title) }}"
                        required>
                </div>

                <div class="form-group">
                    <label>Tanggal Kegiatan</label>
                    <input
                        type="date"
                        name="activity_date"
                        class="form-control"
                        value="{{ old('activity_date', $gallery->activity_date) }}"
                        required>
                </div>

                <div class="form-group">

                    <label>
                        Deskripsi
                        <span class="required">*</span>
                    </label>

                    <x-tiptap
                        name="description"
                        :value="old('description', $gallery->description)"
                        placeholder="Masukkan deskripsi kegiatan..."
                        :image="false" />

                    @error('description')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror

                </div>

                {{-- Media yang sudah ada --}}
                <div class="form-group">
                    <label>Media Saat Ini</label>

                    <div id="existingMedia">

                        @forelse($gallery->media as $media)

                        <div class="media-item">

                            @if($media->type == 'image')

                            <img
                                src="{{ asset('storage/'.$media->file_path) }}"
                                class="media-preview">

                            @else

                            <iframe
                                width="200"
                                height="120"
                                src="https://www.youtube.com/embed/{{ $media->youtube_id }}"
                                frameborder="0"
                                allowfullscreen>
                            </iframe>

                            @endif


                            <button
                                type="button"
                                class="btn-delete-media"
                                data-id="{{ $media->id }}"
                                onclick="deleteMedia(this.dataset.id, this)">

                                <i class="fa-solid fa-trash"></i>
                                Hapus

                            </button>

                        </div>

                        @empty

                        <p class="text-muted">
                            Belum ada media.
                        </p>

                        @endforelse

                    </div>

                </div>

                <div id="edit-photo-container">

    <div class="form-group photo-item">

        <label>Tambah Foto</label>

        <div class="input-with-action">

            <input
                type="file"
                name="images[]"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp">

        </div>

        <small class="text-muted">
            Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB per file.
        </small>

    </div>

</div>

                <button
                    type="button"
                    id="btn-edit-add-photo"
                    class="btn btn-secondary">

                    + Tambah Foto

                </button>

                <div id="edit-video-container">

    <div class="form-group video-item">

        <label>Tambah Video YouTube</label>

        <div class="input-with-action">

            <input
                type="url"
                name="videos[]"
                class="form-control"
                placeholder="https://www.youtube.com/watch?v=xxxx">

        </div>

    </div>

</div>

                <button
                    type="button"
                    id="btn-edit-add-video"
                    class="btn btn-secondary">

                    + Tambah Link Video

                </button>


                <div class="modal-footer">

                    <a href="{{ route('admin.gallery.index') }}"
                        class="btn-batal">
                        <i class="fa-solid fa-xmark"></i>
                        Batal

                    </a>

                    <button type="submit" class="btn-simpan">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update Galeri
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