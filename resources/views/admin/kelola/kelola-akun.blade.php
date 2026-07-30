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
        <a href="{{ route('admin.manage-account.create') }}" class="btn-primary">

            <i class="fa-solid fa-user-plus"></i>

            Tambah Akun

        </a>

    </header>

    <!-- ================= CONTENT ================= -->
    <section class="tab-content">

        <div class="settings-card">

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

                                <th>Status</th>

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

                                        @if ($user->status)
                                            <span class="badge-status badge-active">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge-status badge-inactive">
                                                Tidak Aktif
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        <div class="action-buttons">

                                            <!-- ================= EDIT ================= -->
                                            <a href="{{ route('admin.manage-account.edit', $user) }}"
                                                class="btn-icon btn-edit" title="Edit">

                                                <i class="fa-solid fa-pen"></i>

                                            </a>

                                            <!-- ================= DELETE ================= -->
                                            @if (auth()->id() != $user->id)
                                                <form action="{{ route('admin.manage-account.destroy', $user) }}"
                                                    method="POST" class="delete-form" style="display:inline;">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn-icon btn-delete" title="Hapus">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        Belum ada akun.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    <!-- ================= PAGINATION ================= -->
                    <div class="pagination-section">

                        <div class="info-data">

                            Menampilkan

                            <strong>{{ $users->firstItem() ?? 0 }}</strong>

                            -

                            <strong>{{ $users->lastItem() ?? 0 }}</strong>

                            dari

                            <strong>{{ $users->total() }}</strong>

                            data

                        </div>

                        <div class="pagination-controls">

                            {{-- Previous --}}
                            @if ($users->onFirstPage())
                                <button class="page-btn" disabled>
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="page-btn">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </a>
                            @endif

                            <span id="pageInfo">

                                Halaman

                                {{ $users->currentPage() }}

                                dari

                                {{ $users->lastPage() }}

                            </span>

                            {{-- Next --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="page-btn">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            @else
                                <button class="page-btn" disabled>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            @endif

                        </div>

                    </div>

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
            document.addEventListener('DOMContentLoaded', function() {

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
            document.addEventListener('DOMContentLoaded', function() {

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
