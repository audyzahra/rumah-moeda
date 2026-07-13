@extends('admin.layouts.app')

@section('title','Edit Anggota')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
@endpush

@section('content')

<div class="wrapper">

    <main class="content">

        <header class="topbar">
            <div>
                <h1>Edit Anggota Struktur Organisasi</h1>
                <p>Ubah data anggota struktur organisasi.</p>
            </div>
        </header>

        <div class="card">

            <form method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jabatan</label>
                        <input type="text" name="position" class="form-control">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Urutan Tampil</label>
                        <input type="number" name="display_order" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Upload Foto</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="5" class="form-control"></textarea>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>
                        Update
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

@endsection