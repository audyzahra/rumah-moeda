@extends('admin.layouts.app')

@section('title', 'Kelola Akun')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kelola-akun.css') }}">
@endpush

@section('content')

<header class="topbar">

    <div>

        <h1>Kelola Akun</h1>

        <p>
            Kelola seluruh akun pengguna website
        </p>

    </div>

</header>

<section class="tab-content">

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

            <a href="{{ route('admin.manage-account.create') }}" class="btn-primary">

                <i class="fa-solid fa-user-plus"></i>

                Tambah Akun

            </a>

        </div>

        <div class="card-body">
            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table-admin">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Tanggal Dibuat</th>

                            <th width="160">
                                Aksi
                            </th>

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

                                    <div class="action-buttons">

                                        <a href="{{ route('admin.manage-account.edit', $user) }}"
                                            class="btn-icon btn-edit"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        @if(auth()->id() != $user->id)

                                            <button
                                                type="button"
                                                class="btn-icon btn-delete"
                                                title="Hapus"
                                                onclick="openDeleteModal('{{ route('admin.manage-account.destroy', $user) }}')">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

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
<!-- ================= DELETE MODAL ================= -->

<div class="modal" id="deleteModal">

    <div class="modal-content modal-delete">

        <div class="modal-header">

            <h2>Hapus Akun</h2>

            <button
                type="button"
                class="modal-close"
                onclick="closeDeleteModal()">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <div class="modal-body text-center">

            <div class="delete-icon">

                <i class="fa-solid fa-trash-can"></i>

            </div>

            <h3>

                Apakah Anda yakin?

            </h3>

            <p>

                Akun yang dihapus tidak dapat dikembalikan lagi.

            </p>

        </div>

        <div class="modal-footer">

            <button
                type="button"
                class="btn-secondary"
                onclick="closeDeleteModal()">

                Batal

            </button>

            <form
                id="deleteForm"
                method="POST">

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn-delete">

                    <i class="fa-solid fa-trash"></i>

                    Hapus

                </button>

            </form>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/kelola-akun.js') }}"></script>
@endpush