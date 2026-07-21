@extends('admin.layouts.app')

@section('title', 'Detail Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kategori.css') }}">
@endpush

@section('content')

<div class="kategori-container">

    {{-- ================= HEADER ================= --}}
    <div class="kategori-header">

        <div>

            <h1>Detail Kategori</h1>

            <p>Informasi lengkap kategori berita Rumah Moeda.</p>

        </div>

        <a href="{{ route('admin.categories.index') }}" class="btn-batal">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- ================= DETAIL ================= --}}
    <div class="form-card">

        <div class="detail-group">

            <label>Nama Kategori</label>

            <div class="detail-value">

                {{ $category->name }}

            </div>

        </div>

        <div class="detail-group">

            <label>Jumlah Berita</label>

            <div class="detail-value">

                <span class="badge-total">

                    {{ $category->news_count }}

                </span>

            </div>

        </div>

        <div class="detail-group">

            <label>Dibuat Pada</label>

            <div class="detail-value">

                {{ $category->created_at->format('d F Y, H:i') }}

            </div>

        </div>

        <div class="detail-group">

            <label>Terakhir Diubah</label>

            <div class="detail-value">

                {{ $category->updated_at->format('d F Y, H:i') }}

            </div>

        </div>

        <div class="form-footer">

            <a
                href="{{ route('admin.categories.edit', $category->id) }}"
                class="btn-simpan">

                <i class="fa-solid fa-pen"></i>

                Edit Kategori

            </a>

            <a
                href="{{ route('admin.categories.index') }}"
                class="btn-batal">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection
