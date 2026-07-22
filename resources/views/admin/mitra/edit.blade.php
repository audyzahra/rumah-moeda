@extends('admin.layouts.app')

@section('title', 'Edit Mitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mitra.css') }}">
@endpush

@section('content')

<!-- ================= HEADER ================= -->

<header class="topbar">

    <div>

        <h1>Edit Mitra</h1>

        <p>
            Perbarui informasi mitra.
        </p>

    </div>

</header>

<!-- ================= BREADCRUMB ================= -->

<div class="page-breadcrumb">

    <a href="{{ route('admin.partners.index') }}">

        Mitra

    </a>

    <span>></span>

    <span>Edit Mitra</span>

</div>

<!-- ================= FORM ================= -->

<section>

    <div class="settings-card">

        <div class="card-header">

            <div>

                <h3>

                    <i class="fa-solid fa-handshake"></i>

                    Edit Mitra

                </h3>

                <p>

                    Perbarui informasi mitra di bawah ini.

                </p>

            </div>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('admin.partners.update', $mitra) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Nama & Website -->

                <div class="form-row">

                    <div class="form-group form-group-half">

                        <label>

                            Nama Mitra

                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $mitra->name) }}"
                            required>

                    </div>

                    <div class="form-group form-group-half">

                        <label>

                            Website

                        </label>

                        <input
                            type="url"
                            name="website"
                            class="form-control"
                            placeholder="https://example.com"
                            value="{{ old('website', $mitra->website) }}">

                    </div>

                </div>

                <!-- Urutan & Logo -->

                <div class="form-row">

                    <div class="form-group form-group-half">

                        <label>

                            Urutan Tampil

                        </label>

                        <input
                            type="number"
                            name="display_order"
                            class="form-control"
                            min="1"
                            value="{{ old('display_order', $mitra->display_order) }}">

                        <small>

                            Semakin kecil angka, semakin atas tampilnya.

                        </small>

                    </div>

                    <div class="form-group form-group-half">

                        <label>

                            Upload Logo Baru

                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="form-control"
                            accept="image/*">

                        <small>

                            Kosongkan jika logo tidak ingin diganti.

                        </small>

                    </div>

                </div>

                <!-- Preview Logo -->

                @if($mitra->logo)

                    <div class="form-group">

                        <label>

                            Logo Saat Ini

                        </label>

                        <br>

                        <img
                            src="{{ asset('storage/' . $mitra->logo) }}"
                            alt="{{ $mitra->name }}"
                            style="max-height:90px;border-radius:10px;">

                    </div>

                @endif

                <!-- Deskripsi -->

                <div class="form-group">

                    <label>

                        Deskripsi

                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control">{{ old('description', $mitra->description) }}</textarea>

                </div>

                <!-- BUTTON -->

                <div class="form-actions">

                    <a
                        href="{{ route('admin.partners.index') }}"
                        class="btn-secondary">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="btn-primary">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Mitra

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/mitra.js') }}"></script>
@endpush