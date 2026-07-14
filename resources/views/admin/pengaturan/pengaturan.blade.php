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

        {{-- <button class="tab-btn" data-tab="logo">

            <i class="fa-solid fa-image"></i>

            Logo

        </button> --}}

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

            Kelola Akun

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

                <p>Kelola visi dan misi perusahaan</p>

            </div>

            <div class="card-body">

                <form id="visiMisiForm" action="{{ route('admin.visimisi.update') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label>
                            Visi
                            <span class="required">*</span>
                        </label>

                        <textarea id="visiText" name="vision" class="form-control" rows="3" required>{{ old('vision', $vision->vision ?? '') }}</textarea>

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

                            @forelse($missions as $mission)
                                <div class="misi-item">

                                    <textarea class="form-control misi-text" name="missions[]" rows="2" required>{{ old('missions.' . $loop->index, $mission->mission) }}</textarea>

                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>

                            @empty

                                <div class="misi-item">

                                    <textarea class="form-control misi-text" name="missions[]" rows="2" required></textarea>

                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>
                            @endforelse

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
    <!-- TAB : PROFILE PERUSAHAAN ada logo-->
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

                <form action="{{ route('admin.profile.update') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label>
                            Nama Website
                            <span class="required">*</span>
                        </label>

                        <input type="text" id="websiteName" name="website_name" class="form-control"
                            placeholder="Masukkan nama website"
                            value="{{ old('website_name', $setting->website_name ?? '') }}">

                    </div>

                    <form id="logoForm" action="{{ route('admin.logo.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">

                        <label>

                            Logo Saat Ini

                        </label>

                        <div class="logo-current">

                            <img src="{{ Storage::url($setting->website_logo) }}" alt="Logo Rumah Moeda">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>

                            Upload Logo Baru

                            <span class="required">*</span>

                        </label>

                        <div class="logo-upload">

                            <input type="file" id="formLogo" name="website_logo" accept=".png,.jpg,.jpeg,.svg"
                                onchange="previewLogo(event)">

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

                </form>

                    <div class="form-group">

                        <label>
                            Deskripsi Website
                            <span class="required">*</span>
                        </label>

                        <textarea id="websiteDescription" name="website_description" class="form-control" rows="5"
                            placeholder="Masukkan deskripsi website">{{ old('website_description', $setting->website_description ?? '') }}</textarea>

                    </div>

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>
                                Nomor Telepon
                            </label>

                            <input type="text" id="phoneNumber" name="phone_number" class="form-control"
                                placeholder="+62 812-xxxx-xxxx"
                                value="{{ old('phone_number', $setting->phone_number ?? '') }}">

                        </div>

                        <div class="form-group form-group-half">

                            <label>
                                Email
                            </label>

                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="info@rumahmoeda.id" value="{{ old('email', $setting->email ?? '') }}">

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>
                                Nomor Fax
                            </label>

                            <input type="text" id="faxNumber" name="fax_number" class="form-control"
                                placeholder="Nomor Fax" value="{{ old('fax_number', $setting->fax_number ?? '') }}">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Alamat
                        </label>

                        <textarea id="address" name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', $setting->address ?? '') }}</textarea>

                    </div>

                    <hr>

                    <h4 class="section-title">

                        Sosial Media

                    </h4>

                    <div class="form-group">

                        <label>

                            Instagram

                        </label>

                        <input type="text" id="instagram" name="instagram_url" class="form-control"
                            placeholder="https://instagram.com/..."
                            value="{{ old('instagram_url', $setting->instagram_url ?? '') }}">

                    </div>

                    <div class="form-group">

                        <label>

                            Facebook

                        </label>

                        <input type="text" id="facebook" name="facebook_url" class="form-control"
                            placeholder="https://facebook.com/..."
                            value="{{ old('facebook_url', $setting->facebook_url ?? '') }}">

                    </div>

                    <div class="form-group">

                        <label>

                            TikTok

                        </label>

                        <input type="text" id="tiktok" name="tiktok_url" class="form-control"
                            placeholder="https://tiktok.com/..."
                            value="{{ old('tiktok_url', $setting->tiktok_url ?? '') }}">

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

    </section>
    <!-- ======================================== -->
    <!-- TAB : HERO SECTION -->
    <!-- ======================================== -->

    <section class="tab-content" id="tab-hero">

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

                            <input type="file" id="heroImage" name="hero_image" accept="image/*"
                                onchange="previewHero(event)">

                            <div class="hero-preview" id="heroPreview">

                                <i class="fa-solid fa-cloud-upload-alt"></i>

                                <p>Klik untuk memilih gambar</p>

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
    <!-- TAB : KELOLA AKUN -->
    <!-- ======================================== -->

    <section class="tab-content" id="tab-admin">

        <div class="settings-card">

            <div class="card-header">

                <div>

                    <h3>
                        <i class="fa-solid fa-users"></i>
                        Kelola Akun
                    </h3>

                    <p>
                        Kelola seluruh akun pengguna website
                    </p>

                </div>

                <button type="button" class="btn-primary" onclick="openModalTambahAdmin()">

                    <i class="fa-solid fa-user-plus"></i>

                    Tambah Akun

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

                                <th>Tanggal Dibuat</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $user->name }}</td>

                                    <td>{{ $user->email }}</td>

                                    <td>

                                        <span class="badge-admin">

                                            {{ ucfirst($user->role) }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        <button type="button" class="btn-icon btn-edit" title="Edit"
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}" data-role="{{ $user->role }}"
                                            onclick="openModalEditAdmin(this)">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        @if (auth()->id() != $user->id)
                                            <button type="button" class="btn-icon btn-delete" title="Hapus"
                                                data-id="{{ $user->id }}" onclick="openModalHapusAdmin(this)">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" style="text-align:center;padding:30px;">

                                        Belum ada akun.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

    <!-- ======================================== -->
    <!-- MODAL TAMBAH AKUN -->
    <!-- ======================================== -->

    <div class="modal" id="modalTambahAdmin">

        <div class="modal-content">

            <div class="modal-header">

                <h3>

                    Tambah Akun

                </h3>

                <button type="button" class="close" onclick="closeModalTambahAdmin()">

                    &times;

                </button>

            </div>

            <form action="{{ route('admin.user.store') }}" method="POST">

                @csrf

                <div class="form-group">

                    <label>Nama</label>

                    <input type="text" name="name" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email" name="email" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input type="password" name="password" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Konfirmasi Password</label>

                    <input type="password" name="password_confirmation" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role" class="form-control">

                        <option value="admin">Admin</option>
                        <option value="user">User</option>

                    </select>

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
    <!-- MODAL EDIT AKUN -->
    <!-- ======================================== -->

    <div class="modal" id="modalEditAdmin">

        <div class="modal-content">

            <div class="modal-header">

                <h3>

                    Edit Akun

                </h3>

                <button type="button" class="close" onclick="closeModalEditAdmin()">

                    &times;

                </button>

            </div>

            <form id="formEditAdmin" method="POST">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label>Nama</label>

                    <input type="text" id="edit_name" name="name" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email" id="edit_email" name="email" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Password Baru</label>

                    <input type="password" name="password" class="form-control">

                    <small>
                        Kosongkan jika tidak ingin mengganti password.
                    </small>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select id="edit_role" name="role" class="form-control">

                        <option value="admin">Admin</option>
                        <option value="user">User</option>

                    </select>

                </div>

                <div class="form-actions">

                    <button type="button" class="btn-secondary" onclick="closeModalEditAdmin()">

                        Batal

                    </button>

                    <button type="submit" class="btn-primary">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- ======================================== -->
    <!-- MODAL HAPUS AKUN -->
    <!-- ======================================== -->

    <div class="modal" id="modalHapusAdmin">

        <div class="modal-content modal-delete">

            <div class="modal-header">

                <h3>

                    Hapus Akun

                </h3>

                <button type="button" class="close" onclick="closeModalHapusAdmin()">

                    &times;

                </button>

            </div>

            <div class="modal-body">

                <p>

                    Apakah Anda yakin ingin menghapus akun ini?

                </p>

                <form id="formDeleteAdmin" method="POST">

                    @csrf
                    @method('DELETE')

                    <div class="form-actions">

                        <button type="button" class="btn-secondary" onclick="closeModalHapusAdmin()">

                            Batal

                        </button>

                        <button type="submit" class="btn-danger">

                            Hapus

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/admin/pengaturan.js') }}"></script>
@endpush
