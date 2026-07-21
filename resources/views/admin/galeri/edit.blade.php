@extends('admin.layouts.app')

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

        <a href="{{ route('admin.gallery.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </header>

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
                    <label>Deskripsi</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="4">{{ old('description', $gallery->description) }}</textarea>
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

                    <div class="form-group">

                        <label>Tambah Foto</label>

                        <input
                            type="file"
                            name="images[]"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">

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

                    <div class="form-group">

                        <label>Tambah Video YouTube</label>

                        <input
                            type="url"
                            name="videos[]"
                            class="form-control"
                            placeholder="https://www.youtube.com/watch?v=xxxx">

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

                        Batal

                    </a>

                    <button type="submit" class="btn-simpan">
                        Update
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