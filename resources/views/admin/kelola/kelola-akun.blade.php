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
    {{-- ================== FILTER ================= --}}
    <form method="GET" id="accountFilter" class="filter-section">

        <div class="filter-left">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="search-input"
                placeholder="Cari nama atau email...">

            <select
                name="role"
                class="filter-select">

                <option value="">Semua Role</option>

                <option value="admin"
                    {{ request('role')=='admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="user"
                    {{ request('role')=='user' ? 'selected' : '' }}>
                    User
                </option>

            </select>

            <select
                name="status"
                class="filter-select">

                <option value="">Semua Status</option>

                <option value="1"
                    {{ request('status')==='1' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="0"
                    {{ request('status')==='0' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>

            </select>

            <select
                name="sort"
                class="filter-select">

                <option value="">Urutkan</option>

                <option value="latest"
                    {{ request('sort')=='latest' ? 'selected' : '' }}>
                    Terbaru
                </option>

                <option value="oldest"
                    {{ request('sort')=='oldest' ? 'selected' : '' }}>
                    Terlama
                </option>

                <option value="name_asc"
                    {{ request('sort')=='name_asc' ? 'selected' : '' }}>
                    Nama A-Z
                </option>

                <option value="name_desc"
                    {{ request('sort')=='name_desc' ? 'selected' : '' }}>
                    Nama Z-A
                </option>

            </select>

            <button
                type="button"
                class="btn-refresh"
                onclick="location.href='{{ route('admin.manage-account.index') }}'">

                <i class="fa-solid fa-rotate-right"></i>

            </button>

        </div>

    </form>

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
                    <div class="custom-pagination">

                        {{-- ==========================================
                            SHOW ENTRIES
                        ========================================== --}}
                        <div class="pagination-left">

                            <form method="GET" id="perPageForm">

                                @foreach(request()->except('per_page','page') as $key => $value)

                                    <input
                                        type="hidden"
                                        name="{{ $key }}"
                                        value="{{ $value }}">

                                @endforeach

                                <span>Tampilkan</span>

                                <select
                                    name="per_page"
                                    id="perPageSelect"
                                    onchange="this.form.submit()">

                                    <option value="5" {{ request('per_page',5)==5 ? 'selected' : '' }}>
                                        5
                                    </option>

                                    <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>
                                        10
                                    </option>

                                    <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>
                                        20
                                    </option>

                                    <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>
                                        50
                                    </option>

                                </select>

                                <span>Akun</span>

                            </form>

                        </div>


                        {{-- ==========================================
                            INFO DATA
                        ========================================== --}}
                        <div class="pagination-center">

                            <span>Menampilkan</span>

                            <strong>{{ $users->firstItem() ?? 0 }}</strong>

                            <span>-</span>

                            <strong>{{ $users->lastItem() ?? 0 }}</strong>

                            <span>dari</span>

                            <strong>{{ $users->total() }}</strong>

                            <span>data</span>

                        </div>


                        {{-- ==========================================
                            PAGINATION
                        ========================================== --}}
                        <div class="pagination-right">

                            {{-- Previous --}}
                            @if($users->onFirstPage())

                                <button class="page-btn" disabled>

                                    <i class="fa-solid fa-chevron-left"></i>

                                </button>

                            @else

                                <a
                                    href="{{ $users->previousPageUrl() }}"
                                    class="page-btn">

                                    <i class="fa-solid fa-chevron-left"></i>

                                </a>

                            @endif


                            @php

                                $start = max($users->currentPage() - 1, 1);

                                $end = min($start + 1, $users->lastPage());

                                if($end - $start < 1){

                                    $start = max($end - 1, 1);

                                }

                            @endphp


                            @for($page = $start; $page <= $end; $page++)

                                @if($page == $users->currentPage())

                                    <span class="page-number active">

                                        {{ $page }}

                                    </span>

                                @else

                                    <a
                                        href="{{ $users->url($page) }}"
                                        class="page-number">

                                        {{ $page }}

                                    </a>

                                @endif

                            @endfor


                            {{-- Next --}}
                            @if($users->hasMorePages())

                                <a
                                    href="{{ $users->nextPageUrl() }}"
                                    class="page-btn">

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
