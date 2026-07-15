@extends('user.layouts.app')

@section('title', 'Edit Galeri')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/galeri.css') }}">
@endpush

@section('content')

    <div class="gallery-container">

        {{-- ================= HEADER ================= --}}
        <div class="gallery-header">

            <div>

                <h1>Edit Galeri</h1>

                <p>Perbarui dokumentasi kegiatan Rumah Moeda.</p>

            </div>

            <a href="{{ route('user.gallery.index') }}" class="btn-batal">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

        {{-- ================= FORM ================= --}}
        <div class="form-card">

            <form action="{{ route('user.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- ================= JUDUL ================= --}}
                <div class="form-group">

                    <label>

                        Judul Dokumentasi

                        <span class="required">*</span>

                    </label>

                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $gallery->title) }}" placeholder="Masukkan judul dokumentasi">

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
                        value="{{ old('activity_date', \Carbon\Carbon::parse($gallery->activity_date)->format('Y-m-d')) }}">

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

                    <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Masukkan deskripsi kegiatan...">{{ old('description', $gallery->description) }}</textarea>

                    @error('description')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                </div>

                {{-- ================= MEDIA LAMA ================= --}}
                <div class="form-group">

                    <label>Media Saat Ini</label>

                    <div class="preview-grid">

                        @foreach ($gallery->media as $media)
                            <div class="preview-item">

                                @if ($media->type == 'image')
                                    <img src="{{ asset('storage/' . $media->file_path) }}" class="preview-image">
                                @elseif($media->type == 'video')
                                    @php

                                        $youtubeId = '';

                                        if ($media->video_url) {
                                            $host = parse_url($media->video_url, PHP_URL_HOST);

                                            if ($host && str_contains($host, 'youtu.be')) {
                                                $youtubeId = ltrim(parse_url($media->video_url, PHP_URL_PATH), '/');
                                            } else {
                                                parse_str(parse_url($media->video_url, PHP_URL_QUERY), $query);

                                                $youtubeId = $query['v'] ?? '';
                                            }
                                        }

                                    @endphp

                                    @if ($youtubeId)
                                        <iframe width="220" height="150"
                                            src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                @endif

                            </div>
                        @endforeach

                    </div>

                </div>
                {{-- ================= FOTO BARU ================= --}}
                <div class="form-group">

                    <label>

                        Tambah Foto Baru

                    </label>

                    <input type="file" id="photoInput" name="photos[]"
                        class="form-control @error('photos') is-invalid @enderror" accept="image/*" multiple>

                    <small class="text-muted">

                        Kosongkan jika tidak ingin menambah foto baru.

                    </small>

                    @error('photos')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                    @error('photos.*')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                    <div id="photoPreview" class="preview-grid">

                    </div>

                </div>

                {{-- ================= VIDEO BARU ================= --}}
                <div class="form-group">

                    <label>

                        Tambah Link Video YouTube

                    </label>

                    <div id="videoContainer">

                        <div class="video-input">

                            <input type="url" name="videos[]" class="form-control"
                                placeholder="https://www.youtube.com/watch?v=...">

                        </div>

                    </div>

                    <button type="button" id="btnTambahVideo" class="btn-secondary">

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

                        Update Dokumentasi

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        const photoInput = document.getElementById('photoInput');

        if (photoInput) {

            photoInput.addEventListener('change', function(e) {

                const preview = document.getElementById('photoPreview');

                preview.innerHTML = '';

                Array.from(e.target.files).forEach(file => {

                    const reader = new FileReader();

                    reader.onload = function(event) {

                        preview.innerHTML += `

                    <div class="preview-item">

                        <img src="${event.target.result}">

                    </div>

                `;

                    };

                    reader.readAsDataURL(file);

                });

            });

        }

        const btnTambahVideo = document.getElementById('btnTambahVideo');

        if (btnTambahVideo) {

            btnTambahVideo.addEventListener('click', function() {

                const container = document.getElementById('videoContainer');

                container.insertAdjacentHTML('beforeend', `

            <div
                class="video-input"
                style="display:flex;gap:10px;margin-top:10px;">

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

        }

        document.addEventListener('click', function(e) {

            if (e.target.closest('.remove-video')) {

                e.target.closest('.video-input').remove();

            }

        });
    </script>
@endpush
