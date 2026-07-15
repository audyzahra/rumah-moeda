@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/berita.css') }}">
@endpush

@section('content')

<div class="berita-container">

<div class="back-wrapper">
        <a href="{{ route('admin.berita.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    {{-- HEADER --}}
    <div class="berita-header">

        <div>
            <h1>Edit Berita</h1>
            <p>Perbarui data berita Rumah Moeda.</p>
        </div>


    </div>

    {{-- FORM --}}
    <div class="modal-content">

        <form
            action="{{ route('admin.berita.update', $news->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="modal-body">

                {{-- Judul --}}
                <div class="form-group">

                    <label>
                        Judul Berita
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $news->title) }}"
                        placeholder="Masukkan judul berita">

                </div>

                {{-- Kategori --}}
                <div class="form-group">

                    <label>
                        Kategori
                        <span class="required">*</span>
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="form-control">

                        <option value="">Pilih Kategori</option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ $news->category_id == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Thumbnail --}}
                <div class="form-group">

                    <label>
                        Thumbnail
                    </label>

                    <input
                        type="file"
                        id="thumbnail"
                        name="thumbnail"
                        class="form-control"
                        onchange="previewImage(event)">

                    <small>
                        Format JPG, JPEG, PNG maksimal 2 MB
                    </small>

                    @if($news->thumbnail)

                        <div class="image-preview" style="margin-top:15px;">

                            <img
                                id="preview"
                                src="{{ Storage::url($news->thumbnail) }}"
                                style="max-width:250px;border-radius:10px;">

                        </div>

                    @else

                        <div class="image-preview">

                            <img
                                id="preview"
                                src=""
                                style="display:none;max-width:250px;border-radius:10px;">

                        </div>

                    @endif

                </div>

                {{-- Isi --}}
                <div class="form-group">

                    <label>
                        Isi Berita
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="content"
                        name="content"
                        class="form-control"
                        rows="10"
                        placeholder="Masukkan isi berita...">{{ old('content', $news->content) }}</textarea>

                </div>

                {{-- Publish --}}
                <div class="form-group">

                    <label>
                        Tanggal Publish
                        <span class="required">*</span>
                    </label>

                    <input
                        type="datetime-local"
                        id="publish_date"
                        name="publish_date"
                        class="form-control"
                        value="{{ \Carbon\Carbon::parse($news->publish_date)->format('Y-m-d\TH:i') }}">

                </div>

            </div>

            <div class="modal-footer">

                <a
                    href="{{ route('admin.berita.index') }}"
                    class="btn-batal">

                    <i class="fa-solid fa-xmark"></i>

                    Batal

                </a>

                <button
                    type="submit"
                    class="btn-simpan">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Update Berita

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/berita.js') }}"></script>
@endpush
