@extends('admin.layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/portfolio-category/create.css') }}">
    @endpush


    <div class="content">

        <header class="topbar">

            <div>
                <h1>Tambah Kategori Portofolio</h1>
                <p>Tambahkan kategori baru untuk portofolio</p>
            </div>


            <a href="{{ route('admin.portfolio-categories.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>

        </header>



        <div class="portfolio-category-form">


            <form action="{{ route('admin.portfolio-categories.store') }}" method="POST" class="portfolio-form">


                @csrf



                <div class="form-group">

                    <label>
                        Nama Kategori
                    </label>

                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Website, Mobile App, UI/UX" class="@error('name') is-invalid @enderror">


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

                    <input type="text" id="slug" value="" disabled>


                    <small class="form-info">
                        Slug dibuat otomatis dari nama kategori.
                    </small>

                </div>



                <div class="form-footer">


                    <button type="submit" class="btn-save">

                        <i class="fa-solid fa-save"></i>
                        Simpan Kategori

                    </button>


                </div>



            </form>


        </div>


    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/portfolio_category.js') }}"></script>
@endpush
