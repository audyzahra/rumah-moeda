@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/edit.css') }}">
@endpush


@section('content')
    <div class="content">


        <h1>Edit Portfolio</h1>


        <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="mb-3">

                <label>Kategori</label>

                <select name="category_id" class="form-control">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($portfolio->category_id == $category->id) selected @endif>
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
                        <option value="{{ $partner->id }}" @if ($portfolio->partner_id == $partner->id) selected @endif>

                            {{ $partner->name }}

                        </option>
                    @endforeach


                </select>

            </div>




            <div class="mb-3">

                <label>Judul</label>

                <input name="title" value="{{ $portfolio->title }}" class="form-control">

            </div>




            <div class="mb-3">

                <label>
                    Deskripsi
                    <span class="required">*</span>
                </label>


                <x-tiptap name="description" :value="old('description', $portfolio->description)" placeholder="Tulis deskripsi portfolio..."
                    :image="false" />


                @error('description')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror


            </div>


            <div class="mb-3">

                <label>Tanggal Kegiatan</label>

                <input type="date" name="activity_date" value="{{ $portfolio->activity_date->format('Y-m-d') }}"
                    class="form-control">

            </div>




            <div class="mb-3">

                <label>Lokasi</label>

                <input type="text" name="location" value="{{ $portfolio->location }}" class="form-control">

            </div>


            <div class="mb-3">

                <label>Jumlah Peserta</label>

                <input type="number" name="participants" value="{{ $portfolio->participants }}" class="form-control">

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
