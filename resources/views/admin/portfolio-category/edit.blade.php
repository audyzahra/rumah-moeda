@extends('admin.layouts.app')

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


        <a href="{{ route('admin.portfolio-categories.index') }}" class="btn-add">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

    </header>



    <div class="portfolio-category-table">


        <form action="{{ route('admin.portfolio-categories.update', $category->id) }}"
              method="POST"
              class="portfolio-form">


            @csrf
            @method('PUT')



            <div class="form-group">

                <label>
                    Nama Kategori
                </label>


                <input type="text"
       id="name"
       name="name"
       value="{{ old('name', $category->name) }}"
       class="@error('name') is-invalid @enderror"
       placeholder="Masukkan nama kategori">


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


                <input type="text"
       id="slug"
       value="{{ $category->slug }}"
       readonly>


                <small class="form-info">
                    Slug dibuat otomatis dari nama kategori
                </small>


            </div>




            <div class="form-footer">


                <button type="submit" class="btn-save">

                    <i class="fa-solid fa-save"></i>
                    Simpan Perubahan

                </button>


            </div>



        </form>


    </div>


</div>


@endsection

@push('scripts')
<script src="{{ asset('js/admin/portfolio_category.js') }}"></script>
@endpush
