@extends('admin.layouts.app')

@section('title', 'Edit Akun')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kelola-akun.css') }}">
@endpush
@php
    use Illuminate\Support\Facades\Crypt;
@endphp
@section('content')

    <!-- ================= HEADER ================= -->
    <header class="topbar">

        <div>

            <h1>Edit Akun</h1>

            <p>
                Perbarui informasi akun pengguna.
            </p>

        </div>

    </header>

    <!-- ================= BREADCRUMB ================= -->
    <div class="page-breadcrumb">

        <a href="{{ route('admin.manage-account.index') }}">

            Kelola Akun

        </a>

        <span>></span>

        <span>Edit Akun</span>

    </div>

    <!-- ================= FORM ================= -->
    <section class="user-management-section">

        <div class="settings-card">

            <div class="card-body">

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Periksa kembali data',
                                html: `{!! implode('<br>', $errors->all()) !!}`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5'
                            });

                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "{{ session('error') }}",
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5'
                            });

                        });
                    </script>
                @endif

                <form action="{{ route('admin.manage-account.update', Crypt::encryptString($user->id)) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <!-- Nama & Email -->

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Nama

                                <span class="required">*</span>

                            </label>

                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap"
                                value="{{ old('name', $user->name) }}">

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Email

                                <span class="required">*</span>

                            </label>

                            <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email"
                                value="{{ old('email', $user->email) }}">

                        </div>

                    </div>

                    <!-- Password -->

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Password Baru

                            </label>

                            <div class="password-wrapper">

                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak diubah">

                                <i class="fa-solid fa-eye toggle-password" data-target="password">

                                </i>

                            </div>

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Konfirmasi Password Baru

                            </label>

                            <div class="password-wrapper">

                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Ulangi password baru">

                                <i class="fa-solid fa-eye toggle-password" data-target="password_confirmation">

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

                        <select name="role" class="form-control">

                            <option value="" disabled>

                                -- Pilih Role --

                            </option>

                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>

                                Admin

                            </option>

                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>

                                User

                            </option>

                        </select>

                    </div>
                    <!-- STATUS -->

                    <div class="form-group">

                        <label>

                            Status

                            <span class="required">*</span>

                        </label>

                        <select name="status" class="form-control">

                            <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>

                                Tidak Aktif

                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->

                    <div class="form-actions">

                        <a href="{{ route('admin.manage-account.index') }}" class="btn-secondary">

                            Batal

                        </a>

                        <button type="submit" class="btn-primary">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Update Akun

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
