@extends('admin.layouts.app')

@section('title', 'Hero Section')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/hero-section.css') }}">
@endpush

@section('content')

<section class="tab-content">

    <div class="settings-card">

        <div class="card-header">

            <h3>
                <i class="fa-solid fa-image"></i>
                Hero Section
            </h3>

            <p>
                Kelola gambar utama halaman Home
            </p>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="form-group">

                    <label>
                        Hero Saat Ini
                    </label>

                    <div class="hero-current">

                        @if (!empty($setting->hero_image))
                            <img src="{{ Storage::url($setting->hero_image) }}" alt="Hero Image">
                        @else
                            <p>Belum ada gambar hero.</p>
                        @endif

                    </div>

                </div>

                <div class="form-group">

                    <label>
                        Upload Hero Baru
                        <span class="required">*</span>
                    </label>

                    <div class="hero-upload">

                        <input
                            type="file"
                            id="heroImage"
                            name="hero_image"
                            accept="image/*"
                            onchange="previewHero(event)"
                        >

                        <div class="hero-preview" id="heroPreview">

                            <i class="fa-solid fa-cloud-upload-alt"></i>

                            <p>Klik untuk memilih gambar</p>

                            <small>
                                Format: JPG, JPEG, PNG
                                <br>
                                Maksimal 5 MB
                                <br>
                                Disarankan ukuran 1920 × 1080 px
                            </small>

                        </div>

                    </div>

                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-simpan">

                        <i class="fa-solid fa-save"></i>

                        Simpan Hero

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection
@push('scripts')
    <script src="{{ asset('js/admin/hero-section.js') }}"></script>
@endpush