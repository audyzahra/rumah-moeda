@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/create.css') }}">
@endpush


@section('content')
    <div class="content">


        <h1>Tambah Portfolio</h1>


        <form action="{{ route('admin.portfolios.store') }}" method="POST">

            @csrf


            <div class="mb-3">

                <label>Kategori</label>

                <select name="category_id" class="form-control">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

            </div>




            <div class="mb-3">

                <label>Mitra</label>

                <select name="partner_id" class="form-control">


                    <option value="">
                        Tanpa Mitra
                    </option>


                    @foreach ($partners as $partner)
                        <option value="{{ $partner->id }}">
                            {{ $partner->name }}
                        </option>
                    @endforeach


                </select>

            </div>




            <div class="mb-3">

                <label>Judul</label>

                <input type="text" name="title" class="form-control">

            </div>




            <div class="mb-3">

                <label>
                    Deskripsi
                    <span class="required">*</span>
                </label>


                <x-tiptap name="description" :value="old('description')" placeholder="Tulis deskripsi portfolio..."
                    :image="false" />


                @error('description')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror


            </div>



            <div class="mb-3">

                <label>Tanggal Kegiatan</label>

                <input type="date" name="activity_date" class="form-control">

            </div>




            <div class="mb-3">

                <label>Lokasi</label>

                <input type="text" name="location" class="form-control">

            </div>



            <div class="mb-3">

                <label>Jumlah Peserta</label>

                <input type="number" name="participants" class="form-control">

            </div>



            <button class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">

                Batal

            </a>

        </form>


    </div>
@endsection
