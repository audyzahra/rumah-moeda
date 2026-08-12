@extends('admin.layouts.app')

@section('title', 'Edit Anggota')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
@endpush
@php
    use Illuminate\Support\Facades\Crypt;
@endphp
@section('content')

    <div class="wrapper">

        <main class="content">

            <header class="topbar">
                <div>
                    <h1>Edit Anggota Struktur Organisasi</h1>
                    <p>Ubah data anggota struktur organisasi.</p>
                </div>
            </header>
            <!-- ================= BREADCRUMB ================= -->

            <div class="page-breadcrumb">

                <a href="{{ route('admin.organization-structures.index') }}">

                    Struktur Organisasi

                </a>

                <span>></span>

                <span>Edit Anggota</span>

            </div>

            <div class="card">

                <form id="strukturForm"
                    action="{{ route('admin.organization-structures.update', Crypt::encryptString($organization->id)) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf 
                    @method('PUT') 
                    <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap <span class="required">*</span> </label>
                        <input type="text" name="full_name" class="form-control"
                            value="{{ old('full_name', $organization->full_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jabatan <span class="required">*</span> </label>
                        <input type="text" name="position" class="form-control"
                            value="{{ old('position', $organization->position) }}">
                    </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Posisi Struktur <span class="required">*</span> </label>

                    <select id="typeSelect" class="form-control">

                        <option value="parent" {{ old('parent_id', $organization->parent_id) ? '' : 'selected' }}>
                            Parent
                        </option>

                        <option value="child" {{ old('parent_id', $organization->parent_id) ? 'selected' : '' }}>
                            Child
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label>Upload Foto <span class="required">*</span> </label>
                    <input type="file" name="photo" class="form-control">
                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3" id="parentWrapper"
                    style="{{ old('parent_id', $organization->parent_id) ? '' : 'display:none;' }}">

                    <label>Parent <span class="required">*</span> </label>

                    <select id="parentSelect" name="parent_id" class="form-control">
                        <option value="">-- Parent Utama --</option>

                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $organization->parent_id) == $parent->id ? 'selected' : '' }}>

                                {{ $parent->full_name }} ({{ $parent->position }})

                            </option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label>
                    Deskripsi
                </label>

                <x-tiptap name="description" :value="old('description', $organization->description)" placeholder="Masukkan deskripsi..." :image="false" />

                @error('description')
                    <small class="text-danger">

                        {{ $message }}

                    </small>
                @enderror

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.organization-structures.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-xmark"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Update Anggota
                </button>

            </div>

            </form>

    </div>

    </main>

    </div>

@endsection
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Input Ditolak',
                text: @json(session('error')),
                confirmButtonColor: '#dc2626',
            });
        });
    </script>
@endif

@push('scripts')
    <script src="{{ asset('js/admin/struktur.js') }}"></script>
@endpush
