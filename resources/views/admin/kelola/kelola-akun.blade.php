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

<!-- ================= CONTENT ================= -->
<section class="tab-content">

    <div class="settings-card">

        <!-- ================= CARD HEADER ================= -->
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

        <!-- ================= CARD BODY ================= -->
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

                                        <!-- ================= EDIT ================= -->
                                        <a href="{{ route('admin.manage-account.edit', $user) }}"
                                            class="btn-icon btn-edit"
                                            title="Edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        <!-- ================= DELETE ================= -->
                                        @if(auth()->id() != $user->id)

                                            <form
                                                action="{{ route('admin.manage-account.destroy', $user) }}"
                                                method="POST"
                                                class="delete-form"
                                                style="display:inline;">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-icon btn-delete"
                                                    title="Hapus">

                                                    <i class="fa-solid fa-trash"></i>

                                                </button>

                                            </form>

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

@endsection

@push('scripts')

    <!-- ================= SWEETALERT ================= -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ================= PAGE SCRIPT ================= -->
    <script src="{{ asset('js/admin/kelola-akun.js') }}"></script>

    <!-- ================= SUCCESS ALERT ================= -->
    @if (session('success'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                Swal.fire({
                    icon: 'success',
                    title: '{{ session('title') ?? 'Berhasil!' }}',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#D4AF37',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });

            });
        </script>

    @endif

    <!-- ================= ERROR ALERT ================= -->
    @if (session('error'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });

            });
        </script>

    @endif

@endpush