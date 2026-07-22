@extends('admin.layouts.app')

@section('title', 'Profil Perusahaan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/profil-perusahaan.css') }}">
@endpush

@section('content')

<section class="profile-section">

    <div class="settings-card">

        <div class="card-header">

            <h3>
                <i class="fa-solid fa-building"></i>
                Profil Perusahaan
            </h3>

            <p>
                Kelola informasi utama perusahaan
            </p>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="form-group">

                    <label>
                        Nama Website
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="websiteName"
                        name="website_name"
                        class="form-control"
                        placeholder="Masukkan nama website"
                        value="{{ old('website_name', $setting->website_name ?? '') }}">

                </div>

                <div class="profile-logo-wrapper">

                    <div class="form-group">

                        <label>Logo Saat Ini</label>

                        <div class="logo-current">

                            @if (!empty($setting->website_logo))
                            <img src="{{ Storage::url($setting->website_logo) }}" alt="Logo Website">
                            @else
                            <p>Belum ada logo.</p>
                            @endif

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Upload Logo Baru
                            <span class="required">*</span>
                        </label>

                        <div class="logo-upload">

                            <input
                                type="file"
                                id="formLogo"
                                name="website_logo"
                                accept=".png,.jpg,.jpeg,.svg"
                                onchange="previewLogo(event)">

                            <div class="logo-preview" id="logoPreview">
                                <p>Klik untuk upload logo</p>
                                <i class="fa-solid fa-cloud-upload-alt"></i>
                                <small>
                                    Format : JPG, PNG, SVG
                                    <br>
                                    Maksimal 2 MB
                                    <br>
                                    Rekomendasi ukuran 200 × 80 px
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>
                        Deskripsi Website
                        <span class="required">*</span>
                    </label>

                    <x-tiptap
                        name="website_description"
                        :value="old('website_description', $setting->website_description ?? '')"
                        placeholder="Masukkan deskripsi website..."
                        :image="false" />

                    @error('website_description')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror

                </div>

                <div class="form-row">

                    <div class="form-group form-group-half">

                        <label>Nomor Telepon</label>

                        <input
                            type="text"
                            id="phoneNumber"
                            name="phone_number"
                            class="form-control"
                            placeholder="+62 812-xxxx-xxxx"
                            value="{{ old('phone_number', $setting->phone_number ?? '') }}">

                    </div>

                    <div class="form-group form-group-half">

                        <label>Email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="info@website.com"
                            value="{{ old('email', $setting->email ?? '') }}">

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group form-group-half">

                        <label>Nomor Fax</label>

                        <input
                            type="text"
                            id="faxNumber"
                            name="fax_number"
                            class="form-control"
                            placeholder="Nomor Fax"
                            value="{{ old('fax_number', $setting->fax_number ?? '') }}">

                    </div>

                </div>

                <div class="form-group">

                    <label>Alamat</label>

                    <textarea
                        id="address"
                        name="address"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan alamat lengkap">{{ old('address', $setting->address ?? '') }}</textarea>

                </div>

                <h4 class="section-title">
                    Sosial Media
                </h4>

                <div class="form-row">

                    <div class="form-group form-group-third">

                        <label>Instagram</label>

                        <input
                            type="text"
                            id="instagram"
                            name="instagram_url"
                            class="form-control"
                            placeholder="https://instagram.com/..."
                            value="{{ old('instagram_url', $setting->instagram_url ?? '') }}">

                    </div>

                    <div class="form-group form-group-third">

                        <label>Facebook</label>

                        <input
                            type="text"
                            id="facebook"
                            name="facebook_url"
                            class="form-control"
                            placeholder="https://facebook.com/..."
                            value="{{ old('facebook_url', $setting->facebook_url ?? '') }}">

                    </div>

                    <div class="form-group form-group-third">

                        <label>TikTok</label>

                        <input
                            type="text"
                            id="tiktok"
                            name="tiktok_url"
                            class="form-control"
                            placeholder="https://tiktok.com/..."
                            value="{{ old('tiktok_url', $setting->tiktok_url ?? '') }}">

                    </div>

                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-simpan">

                        <i class="fa-solid fa-save"></i>

                        Simpan Profil

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection
@push('scripts')
<script src="{{ asset('js/admin/profil-perusahaan.js') }}"></script>
@endpush