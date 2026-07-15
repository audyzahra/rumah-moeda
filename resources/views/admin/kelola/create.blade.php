@extends('admin.layouts.app')

@section('title', 'Tambah Akun')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kelola-akun.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->
    <header class="topbar">

        <div>

            <h1>Tambah Akun</h1>

            <p>
                Tambahkan akun administrator atau pengguna baru.
            </p>

        </div>

    </header>

    <!-- ================= BREADCRUMB ================= -->
    <div class="page-breadcrumb">

        <a href="{{ route('admin.manage-account.index') }}">

            Kelola Akun

        </a>

        <span>/</span>

        <span>Tambah Akun</span>

    </div>

    <!-- ================= FORM ================= -->
    <section class="user-management-section">

        <div class="settings-card">

            <div class="card-header">

                <div>

                    <h3>

                        <i class="fa-solid fa-user-plus"></i>

                        Tambah Akun

                    </h3>

                    <p>

                        Lengkapi informasi akun di bawah ini.

                    </p>

                </div>

                <a href="{{ route('admin.manage-account.index') }}"
                    class="btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>

            </div>

            <div class="card-body">

                {{-- VALIDATION --}}
                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('admin.manage-account.store') }}" method="POST">

                    @csrf

                    <!-- Nama & Email -->

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Nama

                                <span class="required">*</span>

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                required>

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Email

                                <span class="required">*</span>

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan alamat email"
                                value="{{ old('email') }}"
                                required>

                        </div>

                    </div>

                    <!-- Password -->

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Password

                                <span class="required">*</span>

                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Minimal 8 karakter"
                                    required>

                                <i
                                    class="fa-solid fa-eye toggle-password"
                                    data-target="password">

                                </i>

                            </div>

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Konfirmasi Password

                                <span class="required">*</span>

                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password"
                                    required>

                                <i
                                    class="fa-solid fa-eye toggle-password"
                                    data-target="password_confirmation">

                                </i>

                            </div>

                        </div>

                    </div>

                    <!-- ROLE -->

                    <div class="form-group">

                        <label>

                            Role

                            <span class="required">*</span>

                        </label>

                        <select
                            name="role"
                            class="form-control"
                            required>

                            <option value="" selected disabled>

                                -- Pilih Role --

                            </option>

                            <option
                                value="admin"
                                {{ old('role') == 'admin' ? 'selected' : '' }}>

                                Admin

                            </option>

                            <option
                                value="user"
                                {{ old('role') == 'user' ? 'selected' : '' }}>

                                User

                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->

                    <div class="form-actions">

                        <a href="{{ route('admin.manage-account.index') }}"
                            class="btn-secondary">

                            <i class="fa-solid fa-arrow-left"></i>

                            Batal

                        </a>

                        <button
                            type="submit"
                            class="btn-primary">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan Akun

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/kelola-akun.js') }}"></script>
@endpush