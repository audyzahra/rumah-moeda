@extends('admin.layouts.app')

@section('title', 'Kelola Akun')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kelola-akun.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->
    <header class="topbar">
        <div>
            <h1>Kelola Akun</h1>
            <p>
                Kelola seluruh akun pengguna website
            </p>
        </div>
    </header>

    <!-- DATA AKUN -->
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

    <!-- MODAL TAMBAH AKUN -->
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

    <!-- MODAL EDIT AKUN -->
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

                    <button type="button" class="btn-secondary" 
                        onclick="closeModalEditAdmin()">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary">
                        Update
                    </button>

                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS AKUN -->
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

                        <button type="button" class="btn-secondary" 
                            onclick="closeModalHapusAdmin()">
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
    <script src="{{ asset('js/admin/kelola-akun.js') }}"></script>
@endpush