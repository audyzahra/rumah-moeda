@extends('admin.layouts.app')

@section('title', 'Tambah Portofolio')

@push('styles')

 <link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css">


    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/create.css') }}">
@endpush


@section('content')
    <div class="content">


        <h1>Tambah Portfolio</h1>

        <!-- ================= BREADCRUMB ================= -->

            <div class="page-breadcrumb">

                <a href="{{ route('admin.portfolios.index') }}">

                    Portofolio

                </a>

                <span>></span>

                <span>Tambah Portofolio</span>

            </div>


        <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">

            @csrf


            <div class="mb-3">

                <label>Kategori <span class="required">*</span></label>

                <select name="category_id" class="form-control">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

            </div>



            <div class="mb-3">

                <label>Mitra <span class="required">*</span></label>

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

                <label>Judul <span class="required">*</span></label>

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

                <label>Tanggal Kegiatan
                    <span class="required">*</span>
                </label>

                <input type="date" name="activity_date" class="form-control">

            </div>




            <div class="mb-3">

    <label class="form-label">Lokasi
        <span class="required">*</span>
    </label>

    <input
        type="text"
        id="location"
        name="location"
        class="form-control"
        autocomplete="off"
        value="{{ old('location', $portfolio->location ?? '') }}"
    >

    <div
        id="location-result"
        class="list-group mt-1">
    </div>

    <input
        type="hidden"
        id="latitude"
        name="latitude"
        value="{{ old('latitude', $portfolio->latitude ?? '') }}">

    <input
        type="hidden"
        id="longitude"
        name="longitude"
        value="{{ old('longitude', $portfolio->longitude ?? '') }}">

</div>

<div
    id="map"
    style="height:200px"
    class="rounded border">
</div>



            <div class="mb-3">

                <label>Jumlah Peserta</label>

                <input type="number" name="participants" class="form-control">

            </div>


            <div class="mb-3">

                <label>Foto Portfolio
                    <span class="required">*</span>
                </label>


                <div id="imageContainer">


                    <div class="image-item mb-3">


                        <div class="input-group">

                            <input type="file" name="images[]" class="form-control image-input" accept="image/*">


                        </div>


                        <div class="preview-container mt-2"></div>


                    </div>


                </div>



                <button type="button" class="btn btn-primary btn-sm" id="addImage">

                    <i class="fa fa-plus"></i>
                    Tambah Foto

                </button>


            </div>


            <div class="mb-3">

                <label>Video Portfolio (YouTube)</label>


                <div id="videoContainer">

                    <div class="video-item mb-3">


                        <div class="input-group">

                            <input type="text" name="video_url[]" class="form-control video-input"
                                placeholder="https://youtube.com/watch?v=">

                        </div>


                        <div class="video-preview mt-3"></div>


                    </div>

                </div>


                <button type="button" class="btn btn-primary btn-sm" id="addVideo">

                    <i class="fa fa-plus"></i>
                    Tambah Video

                </button>


            </div>



            <div class="modal-footer">

                    <a href="{{ route('admin.portfolios.index') }}" class="btn-batal">

                        <i class="fa-solid fa-xmark"></i>

                        Batal

                    </a>

                    <button type="submit" class="btn-simpan">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Portofolio

                    </button>

                </div>

        </form>


    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="{{ asset('js/admin/portfolio.js') }}"></script>
@endpush
