@extends('admin.layouts.app')

@section('title', 'Edit Portofolio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/edit.css') }}">
@endpush


@section('content')
    <div class="content">


        <h1>Edit Portfolio</h1>

        <!-- ================= BREADCRUMB ================= -->

        <div class="page-breadcrumb">

            <a href="{{ route('admin.portfolios.index') }}">

                Portofolio

            </a>

            <span>></span>

            <span>Edit Portofolio</span>

        </div>

        <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="mb-3">

                <label>Kategori <span class="required">*</span></label>

                <select name="category_id" class="form-control">

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($portfolio->category_id == $category->id) selected @endif>
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
                        <option value="{{ $partner->id }}" @if ($portfolio->partner_id == $partner->id) selected @endif>

                            {{ $partner->name }}

                        </option>
                    @endforeach


                </select>

            </div>




            <div class="mb-3">

                <label>Judul <span class="required">*</span></label>

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

                <label>Tanggal Kegiatan <span class="required">*</span></label>

                <input type="date" name="activity_date" value="{{ $portfolio->activity_date->format('Y-m-d') }}"
                    class="form-control">

            </div>




            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                    <span class="required">*</span>
                </label>

                <input type="text" name="location" class="form-control" placeholder="Masukkan lokasi kegiatan"
                    value="{{ old('location', $portfolio->location) }}">

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Latitude
                </label>

                <input type="text" name="latitude" class="form-control" placeholder="Contoh: -6.3273"
                    value="{{ old('latitude', $portfolio->latitude) }}">

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Longitude
                </label>

                <input type="text" name="longitude" class="form-control" placeholder="Contoh: 108.3247"
                    value="{{ old('longitude', $portfolio->longitude) }}">

            </div>


            <div class="mb-3">

                <label>Jumlah Peserta</label>

                <input type="number" name="participants" value="{{ $portfolio->participants }}" class="form-control">

            </div>


            <div class="mb-3">

                <label>Media Portfolio Saat Ini</label>

                <div class="row g-3">

                    @foreach ($portfolio->media as $media)
                        <div class="col-md-4 media-item" id="media-{{ $media->id }}">


                            <div class="position-relative border rounded p-2">


                                @if ($media->type == 'image')
                                    <img src="{{ asset('storage/' . $media->file_path) }}" class="img-fluid rounded">
                                @elseif ($media->type == 'video')
                                    @php
                                        preg_match(
                                            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&]+)/',
                                            $media->video_url,
                                            $matches,
                                        );

                                        $youtubeId = $matches[1] ?? null;
                                    @endphp


                                    @if ($youtubeId)
                                        <iframe width="100%" height="220"
                                            src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                @endif



                                <button type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-old-media"
                                    data-id="{{ $media->id }}" data-element="media-{{ $media->id }}">

                                    <i class="fa-solid fa-trash"></i>

                                </button>


                            </div>


                        </div>
                    @endforeach


                </div>

            </div>



            <div class="mb-3">

                <label>Tambah Foto Baru</label>


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

                <label>Tambah Video YouTube</label>


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

            <div id="deleteMediaContainer"></div>


            <div class="modal-footer">

                <a href="{{ route('admin.portfolios.index') }}" class="btn-batal">

                    <i class="fa-solid fa-xmark"></i>

                    Batal

                </a>

                <button type="submit" class="btn-simpan">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Update Portofolio

                </button>

            </div>


        </form>


    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/portfolio.js') }}"></script>
@endpush
