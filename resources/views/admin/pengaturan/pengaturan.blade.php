@extends('admin.layouts.app')

@section('title', 'Pengaturan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pengaturan.css') }}">
@endpush

@section('content')

        <!-- ================= HEADER ================= -->
        <header class="topbar">

            <div>

                <h1>Pengaturan</h1>

                <p>
                    Kelola semua pengaturan website
                </p>

            </div>

        </header>

        <!-- ================= TAB NAVIGATION ================= -->

        <nav class="tab-navigation">

            <button class="tab-btn active" data-tab="visimisi">

                <i class="fa-solid fa-bullseye"></i>

                Visi & Misi

            </button>

            <button class="tab-btn" data-tab="logo">

                <i class="fa-solid fa-image"></i>

                Logo

            </button>

            <button class="tab-btn" data-tab="profile">

                <i class="fa-solid fa-building"></i>

                Profile Perusahaan

            </button>

            <button class="tab-btn" data-tab="hero">

                <i class="fa-solid fa-sliders-h"></i>

                Hero Section

            </button>

            <button class="tab-btn" data-tab="admin">

                <i class="fa-solid fa-users-cog"></i>

                Akun Admin

            </button>

        </nav>

        <!-- ======================================== -->
        <!-- TAB : VISI & MISI -->
        <!-- ======================================== -->

        <section class="tab-content active" id="tab-visimisi">

            <div class="settings-card">

                <div class="card-header">

                    <h3>
                        <i class="fa-solid fa-bullseye"></i>
                        Visi & Misi
                    </h3>

                    <p>
                        Kelola visi dan misi perusahaan
                    </p>

                </div>

                <div class="card-body">

                    <form id="visiMisiForm">

                        <div class="form-group">

                            <label>
                                Visi
                                <span class="required">*</span>
                            </label>

                            <textarea id="visiText" class="form-control" rows="3" placeholder="Masukkan visi perusahaan" required></textarea>

                            <small class="form-help">
                                Tuliskan visi perusahaan secara jelas dan inspiratif.
                            </small>

                        </div>

                        <div class="form-group">

                            <label>
                                Misi
                                <span class="required">*</span>
                            </label>

                            <div id="misiContainer">

                                <div class="misi-item">

                                    <textarea class="form-control misi-text" rows="2" placeholder="Masukkan misi ke-1" required></textarea>

                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>

                            </div>

                            <button type="button" class="btn-add-misi" onclick="addMisi()">

                                <i class="fa-solid fa-plus"></i>

                                Tambah Misi

                            </button>

                            <small class="form-help">
                                Setiap misi ditulis dalam satu baris.
                            </small>

                        </div>

                        <div class="form-actions">

                            <button type="submit" class="btn-simpan">

                                <i class="fa-solid fa-save"></i>

                                Simpan Visi & Misi

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

        <!-- ======================================== -->
        <!-- TAB : LOGO -->
        <!-- ======================================== -->

        <section class="tab-content" id="tab-logo">

            <div class="settings-card">

                <div class="card-header">

                    <h3>
                        <i class="fa-solid fa-image"></i>
                        Logo Perusahaan
                    </h3>

                    <p>
                        Kelola logo perusahaan yang tampil di website
                    </p>

                </div>

                <div class="card-body">

                    <form id="logoForm">

                        <div class="form-group">

                            <label>
                                Logo Saat Ini
                            </label>

                            <div class="logo-current" id="currentLogo">

                                <img src="{{ asset('uploads/logo.png') }}" alt="Logo Rumah Moeda">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>
                                Upload Logo Baru
                                <span class="required">*</span>
                            </label>

                            <div class="logo-upload">

                                <input type="file" id="formLogo" accept="image/*" onchange="previewLogo(event)">

                                <div class="logo-preview" id="logoPreview">

                                    <i class="fa-solid fa-cloud-upload-alt"></i>

                                    <p>
                                        Klik untuk upload logo
                                    </p>

                                    <small>

                                        Format :
                                        JPG, PNG, SVG

                                        <br>

                                        Maksimal 2 MB

                                        <br>

                                        Rekomendasi ukuran
                                        200 × 80 px

                                    </small>

                                </div>

                            </div>

                        </div>

                        <div class="form-actions">

                            <button type="submit" class="btn-simpan">

                                <i class="fa-solid fa-save"></i>

                                Simpan Logo

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

        <!-- ======================================== -->
        <!-- TAB : PROFILE PERUSAHAAN -->
        <!-- ======================================== -->

        <section class="tab-content" id="tab-profile">

            <div class="settings-card">

                <div class="card-header">

                    <h3>
                        <i class="fa-solid fa-building"></i>
                        Profile Perusahaan
                    </h3>

                    <p>
                        Kelola informasi utama perusahaan
                    </p>

                </div>

                <div class="card-body">

                    <form id="profileForm">

                        <div class="form-group">

                            <label>
                                Nama Website
                                <span class="required">*</span>
                            </label>

                            <input type="text" id="websiteName" class="form-control" placeholder="Masukkan nama website"
                                value="Rumah Moeda">

                        </div>

                        <div class="form-group">

                            <label>
                                Deskripsi Website
                                <span class="required">*</span>
                            </label>

                            <textarea id="websiteDescription" class="form-control" rows="5" placeholder="Masukkan deskripsi website"></textarea>

                        </div>

                        <div class="form-row">

                            <div class="form-group">

                                <label>

                                    Nomor Telepon

                                </label>

                                <input type="text" id="phoneNumber" class="form-control"
                                    placeholder="+62 812-xxxx-xxxx">

                            </div>

                            <div class="form-group">

                                <label>

                                    Email

                                </label>

                                <input type="email" id="email" class="form-control"
                                    placeholder="info@rumahmoeda.id">

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group">

                                <label>

                                    Nomor Fax

                                </label>

                                <input type="text" id="faxNumber" class="form-control" placeholder="Nomor Fax">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>

                                Alamat

                            </label>

                            <textarea id="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>

                        </div>

                        <hr>

                        <h4 class="section-title">

                            Sosial Media

                        </h4>

                        <div class="form-group">

                            <label>

                                Instagram

                            </label>

                            <input type="text" id="instagram" class="form-control"
                                placeholder="https://instagram.com/...">

                        </div>

                        <div class="form-group">

                            <label>

                                Facebook

                            </label>

                            <input type="text" id="facebook" class="form-control"
                                placeholder="https://facebook.com/...">

                        </div>

                        <div class="form-group">

                            <label>

                                TikTok

                            </label>

                            <input type="text" id="tiktok" class="form-control"
                                placeholder="https://tiktok.com/...">

                        </div>

                        <div class="form-actions">

                            <button type="submit" class="btn-simpan">

                                <i class="fa-solid fa-save"></i>

                                Simpan Profile

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>
        <!-- ======================================== -->
        <!-- TAB : HERO SECTION -->
        <!-- ======================================== -->

        <section class="tab-content" id="tab-hero">

            <div class="settings-card">

                <div class="card-header">

                    <h3>
                        <i class="fa-solid fa-panorama"></i>
                        Hero Section
                    </h3>

                    <p>
                        Kelola gambar utama halaman Home
                    </p>

                </div>

                <div class="card-body">

                    <form id="heroForm">

                        <div class="form-group">

                            <label>
                                Hero Saat Ini
                            </label>

                            <div class="hero-current">

                                <img src="{{ asset('uploads/hero.jpg') }}" id="heroImagePreview" alt="Hero Image">

                            </div>

                        </div>

                        <div class="form-group">

                            <label>
                                Upload Hero Baru
                            </label>

                            <div class="hero-upload">

                                <input type="file" id="heroImage" accept="image/*" onchange="previewHero(event)">

                                <div class="upload-box">

                                    <i class="fa-solid fa-cloud-arrow-up"></i>

                                    <p>
                                        Klik untuk memilih gambar
                                    </p>

                                    <small>

                                        Format :
                                        JPG, JPEG, PNG

                                        <br>

                                        Maksimal 5 MB

                                        <br>

                                        Disarankan ukuran
                                        1920 × 1080 px

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
        <!-- ======================================== -->
        <!-- TAB : AKUN ADMIN -->
        <!-- ======================================== -->

        <section class="tab-content" id="tab-admin">

            <div class="settings-card">

                <div class="card-header">

                    <div>

                        <h3>
                            <i class="fa-solid fa-users-cog"></i>
                            Akun Admin
                        </h3>

                        <p>
                            Kelola akun administrator website
                        </p>

                    </div>

                    <button type="button" class="btn-primary" onclick="openModalTambahAdmin()">

                        <i class="fa-solid fa-user-plus"></i>

                        Tambah Admin

                    </button>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table-admin">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Nama</th>

                                    <th>Email</th>

                                    <th>Role</th>

                                    <th>Aksi</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>1</td>

                                    <td>Administrator</td>

                                    <td>admin@rumahmoeda.id</td>

                                    <td>

                                        <span class="badge-admin">

                                            Admin

                                        </span>

                                    </td>

                                    <td>

                                        <button class="btn-icon btn-edit" title="Edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        <button class="btn-icon btn-delete" title="Hapus">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>
        <!-- ======================================== -->
        <!-- MODAL TAMBAH ADMIN -->
        <!-- ======================================== -->

        <div class="modal" id="modalTambahAdmin">

            <div class="modal-content">

                <div class="modal-header">

                    <h3>
                        Tambah Admin
                    </h3>

                    <button type="button" class="close" onclick="closeModalTambahAdmin()">

                        &times;

                    </button>

                </div>

                <form id="formTambahAdmin">

                    <div class="form-group">

                        <label>Nama</label>

                        <input type="text" class="form-control" placeholder="Masukkan Nama">

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input type="email" class="form-control" placeholder="Masukkan Email">

                    </div>

                    <div class="form-group">

                        <label>Password</label>

                        <input type="password" class="form-control" placeholder="Masukkan Password">

                    </div>

                    <div class="form-actions">

                        <button type="button" class="btn-secondary" onclick="closeModalTambahAdmin()">

                            Batal

                        </button>

                        <button type="submit" class="btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- ======================================== -->
        <!-- MODAL HAPUS ADMIN -->
        <!-- ======================================== -->

        <div class="modal" id="modalHapusAdmin">

            <div class="modal-content modal-delete">

                <h3>

                    Hapus Admin

                </h3>

                <p>

                    Apakah Anda yakin ingin menghapus admin ini?

                </p>

                <div class="form-actions">

                    <button type="button" class="btn-secondary" onclick="closeModalHapusAdmin()">

                        Batal

                    </button>

                    <button type="button" class="btn-danger">

                        Hapus

                    </button>

                </div>

            </div>


    @endsection

    @push('scripts')
        <script src="{{ asset('js/admin/pengaturan.js') }}"></script>
    @endpush
