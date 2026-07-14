@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/berita.css') }}">
@endpush

@section('content')

<div class="berita-container">

    <div class="berita-header">

        <div>

            <h1>Edit Berita</h1>

            <p>Perbarui data berita Rumah Moeda.</p>

        </div>

        <a href="{{ route('admin.berita.index') }}" class="btn-batal">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- isi form sama seperti tambah.blade.php --}}

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/berita.js') }}"></script>
@endpush