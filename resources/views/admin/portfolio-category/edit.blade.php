@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@php
    use Illuminate\Support\Facades\Crypt;
@endphp
@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/portfolio-category/edit.css') }}">
    @endpush


    <div class="content">

        <header class="topbar">

            <div>
                <h1>Edit Kategori Portofolio</h1>
                <p>Ubah informasi kategori portofolio</p>
            </div>

        </header>

        <!-- ================= BREADCRUMB ================= -->

        <div class="page-breadcrumb">

            <a href="{{ route('admin.portfolio-categories.index') }}">

                Kategori

            </a>

            <span>></span>

            <span>Edit Kategori</span>

        </div>

        {{-- FORM EDIT --}}
        <div class="portfolio-category-table">

            <form action="{{ route('admin.portfolio-categories.update', Crypt::encryptString($category->id)) }}"

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label>
                        Nama Kategori
                        <span class="required">*</span>
                    </label>

                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                        class="@error('name') is-invalid @enderror" placeholder="Masukkan nama kategori">

                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>
                        Slug
                    </label>

                    <input type="text" id="slug" value="{{ $category->slug }}" readonly>


                    <small class="form-info">
                        Slug dibuat otomatis dari nama kategori
                    </small>


                </div>

                <div class="form-actions">

                    <a href="{{ route('admin.portfolio-categories.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-xmark"></i>
                        Batal
                    </a>

                    <button type="submit" class="btn-primary">

                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Kategori

                    </button>

                </div>

            </form>

        </div>


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
    <script src="{{ asset('js/admin/portfolio_category.js') }}"></script>
@endpush
