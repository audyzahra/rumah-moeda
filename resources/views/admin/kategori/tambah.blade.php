@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kategori.css') }}">
@endpush

@section('content')

<div class="kategori-container">

    {{-- ================= HEADER ================= --}}
    <div class="kategori-header">

        <div>

            <h1>Tambah Kategori</h1>

            <p>Tambahkan kategori baru untuk berita Rumah Moeda.</p>

        </div>

        <a href="{{ route('admin.kategori.index') }}" class="btn-batal">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- ================= FORM ================= --}}
    <div class="form-card">

        <form
            action="{{ route('admin.kategori.store') }}"
            method="POST">

            @csrf

            <div class="form-group">

                <label>
                    Nama Kategori
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama kategori..."
                    value="{{ old('name') }}"
                    autofocus>

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="form-footer">

                <a
                    href="{{ route('admin.kategori.index') }}"
                    class="btn-batal">

                    <i class="fa-solid fa-xmark"></i>

                    Batal

                </a>

                <button
                    type="submit"
                    class="btn-simpan">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan Kategori

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
