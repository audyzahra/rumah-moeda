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

            <form
            action="{{ route('admin.organization-structures.update', $organization->id) }}"
            method="POST"
            enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text"
       name="full_name"
       class="form-control"
       value="{{ old('full_name', $organization->full_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jabatan</label>
                        <input type="text"
       name="position"
       class="form-control"
       value="{{ old('position', $organization->position) }}">
                    </div>

                </div>

                <div class="row">

    <div class="col-md-6 mb-3">

        <label>Posisi Struktur</label>

        <select id="typeSelect" class="form-control">

            <option value="parent"
                {{ old('parent_id', $organization->parent_id) ? '' : 'selected' }}>
                Parent
            </option>

            <option value="child"
                {{ old('parent_id', $organization->parent_id) ? 'selected' : '' }}>
                Child
            </option>

        </select>

    </div>

    <div class="col-md-6 mb-3">
        <label>Upload Foto</label>
        <input type="file" name="photo" class="form-control">
    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-3"
        id="parentWrapper"
        style="{{ old('parent_id', $organization->parent_id) ? '' : 'display:none;' }}">

        <label>Parent</label>

        <select name="parent_id" class="form-control">

            <option value="">-- Pilih Parent --</option>

            @foreach($parents as $parent)

                <option value="{{ $parent->id }}"
                    {{ old('parent_id', $organization->parent_id) == $parent->id ? 'selected' : '' }}>

                    {{ $parent->full_name }}

                </option>

            @endforeach

        </select>

    </div>

</div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea
    name="description"
    rows="5"
    class="form-control">{{ old('description', $organization->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('admin.organization-structures.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script src="{{ asset('js/admin/struktur.js') }}"></script>
@endpush