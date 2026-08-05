@extends('user.layouts.app')

@section('title', 'Tambah Portofolio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/create.css') }}">
@endpush


@section('content')
    <div class="content">


        <h1>Tambah Portfolio</h1>

        <!-- ================= BREADCRUMB ================= -->

        <div class="page-breadcrumb">

            <a href="{{ route('user.portfolios.index') }}">

                Portofolio

            </a>

            <span>></span>

            <span>Tambah Portofolio</span>

        </div>


        <form action="{{ route('user.portfolios.store') }}" method="POST" enctype="multipart/form-data">

            @csrf


            <div class="mb-3">

                <label>Kategori <span class="required">*</span></label>

                <select name="category_id" class="form-control">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>



            <div class="mb-3">

                <label>Mitra <span class="required">*</span></label>

                <select name="partner_id" class="form-control" required>

                    <option value="" disabled selected>Pilih Mitra</option>

                    @foreach ($partners as $partner)
                        <option value="{{ $partner->id }}"
                            {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                            {{ $partner->name }}
                        </option>
                    @endforeach

                </select>

                @error('partner_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>




            <div class="mb-3">

                <label>Judul <span class="required">*</span></label>

                <input type="text" name="title" class="form-control" value="{{ old('title') }}">

                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>




            <div class="mb-3">

                <label>
                    Deskripsi
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

                <input type="date" name="activity_date" class="form-control" value="{{ old('activity_date') }}">

                @error('activity_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>




            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                    <span class="required">*</span>
                </label>

                <input type="text" name="location" class="form-control" placeholder="Masukkan lokasi kegiatan"
                    value="{{ old('location') }}">
                @error('location')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="mb-3">

                <label class="form-label">
                    Latitude
                </label>

                <input type="text" name="latitude" class="form-control" placeholder="Contoh: -6.3273"
                    value="{{ old('latitude') }}">
                @error('latitude')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Longitude
                </label>

                <input type="text" name="longitude" class="form-control" placeholder="Contoh: 108.3247"
                    value="{{ old('longitude') }}">
                @error('longitude')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">

                <label>Jumlah Peserta</label>

                <input type="number" name="participants" class="form-control" value="{{ old('participants') }}">

                @error('participants')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            <div class="mb-3">

                <label>Foto Portfolio
                    <span class="required">*</span>
                </label>


                <div id="imageContainer">


                    <div class="image-item mb-3">


                        <div class="input-group">

                            <input type="file" name="images[]" class="form-control image-input" accept="image/*">
                            @error('images.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

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
                            @error('video_url.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

                <a href="{{ route('user.portfolios.index') }}" class="btn-batal">

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

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Swal.fire({
                icon: 'error',
                title: 'Data belum lengkap',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#dc2626'
            });

        });
    </script>
@endif

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
    <script src="{{ asset('js/admin/portfolio.js') }}"></script>
@endpush
