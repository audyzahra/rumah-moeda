@extends('admin.layouts.app')

@section('title', 'Aspirasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/aspirasi.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->
    <div class="page-header">
        <h1>Manajemen Aspirasi</h1>
        <p>Kelola semua aspirasi dari pengunjung</p>
    </div>
    <!-- ================= STATISTIK ================= -->

    <div class="aspirasi-stats">

        <div class="stat-card">

            <div class="stat-icon total">
                <i class="fa-solid fa-envelope"></i>
            </div>

            <div>

                <h4>Total Aspirasi</h4>

                <h2 id="total-aspirasi">
                    {{ $totalMessages }}
                </h2>

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon baru">
                <i class="fa-solid fa-envelope-circle-check"></i>
            </div>

            <div>

                <h4>Belum Dibaca</h4>

                <h2 id="belum-dibaca">
                    {{ $unreadMessages }}
                </h2>

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon dibaca">
                <i class="fa-solid fa-envelope-open"></i>
            </div>

            <div>

                <h4>Sudah Dibaca</h4>

                <h2 id="sudah-dibaca">
                    {{ $readMessages }}
                </h2>

            </div>

        </div>

    </div>

    <!-- ================= FILTER ================= -->

    <div class="filter-section">

        <div class="filter-left">

            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau email..."
                value="{{ request('search') }}">

            <select id="filterStatus" class="filter-select">

                <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>
                    Semua Status
                </option>

                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                    Belum Dibaca
                </option>

                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                    Sudah Dibaca
                </option>

            </select>

        </div>

    </div>

    <!-- ================= TABLE ================= -->
    <div class="table-section">

        <div class="table-wrapper">

            <table id="aspirasiTable">

                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="checkAll" onchange="toggleAllCheckbox()">
                        </th>

                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody id="aspirasiBody">

                    @forelse($messages as $message)
                        <tr data-id="{{ $message->id }}" data-name="{{ strtolower($message->full_name) }}"
                            data-email="{{ strtolower($message->email) }}" data-status="{{ $message->is_read ? 1 : 0 }}">

                            <td>

                                <input type="checkbox" class="row-checkbox" value="{{ $message->id }}">

                            </td>

                            <td>

                                <strong>

                                    {{ $message->full_name }}

                                </strong>

                            </td>

                            <td>

                                {{ $message->email }}

                            </td>

                            <td>

                                {{ $message->phone }}

                            </td>

                            <td>

                                {{ \Illuminate\Support\Str::limit($message->message, 10) }}

                            </td>

                            <td>

                                {{ $message->created_at->format('d M Y H:i') }}

                            </td>

                            <td>

                                @if ($message->is_read)
                                    <span class="status-badge dibaca">

                                        Dibaca

                                    </span>
                                @else
                                    <span class="status-badge baru">

                                        Belum Dibaca

                                    </span>
                                @endif

                            </td>

                            <td>

                                <div class="action-buttons">

                                    {{-- Detail --}}
                                    <button class="btn-detail" data-id="{{ $message->id }}"
                                        data-name="{{ $message->full_name }}" data-email="{{ $message->email }}"
                                        data-phone="{{ $message->phone }}" data-message="{{ $message->message }}"
                                        data-status="{{ $message->is_read ? 1 : 0 }}"
                                        data-created="{{ $message->created_at->format('d M Y H:i') }}"
                                        onclick="showDetail(this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>


                                    {{-- Hapus --}}
                                    <button class="btn-hapus" onclick="deleteAspirasi({{ $message->id }})">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" style="text-align:center;padding:30px;">

                                Belum ada aspirasi.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- ================= PAGINATION ================= -->

        <div class="custom-pagination">

            {{-- ==========================================
                SHOW ENTRIES
            ========================================== --}}
            <div class="pagination-left">

                <form method="GET" id="perPageForm">

                    {{-- Pertahankan search dan status --}}
                    @foreach (request()->except('per_page', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach


                    <span>Tampilkan</span>


                    <select name="per_page" onchange="this.form.submit()">

                        <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>
                            5
                        </option>

                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                            10
                        </option>

                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>
                            20
                        </option>

                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                            50
                        </option>

                    </select>


                    <span>Aspirasi</span>

                </form>

            </div>


            {{-- ==========================================
                INFO DATA
            ========================================== --}}
            <div class="pagination-center">

                <span>Menampilkan</span>

                <strong>
                    {{ $messages->firstItem() ?? 0 }}
                </strong>

                <span>-</span>

                <strong>
                    {{ $messages->lastItem() ?? 0 }}
                </strong>

                <span>dari</span>

                <strong>
                    {{ $messages->total() }}
                </strong>

                <span>data</span>

            </div>


            {{-- ==========================================
                PAGINATION
            ========================================== --}}
            <div class="pagination-right">


                {{-- PREVIOUS --}}
                @if ($messages->onFirstPage())
                    <button class="page-btn" disabled>

                        <i class="fa-solid fa-chevron-left"></i>

                    </button>
                @else
                    <a href="{{ $messages->previousPageUrl() }}" class="page-btn">

                        <i class="fa-solid fa-chevron-left"></i>

                    </a>
                @endif


                {{-- NOMOR HALAMAN --}}
                @foreach ($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                    @if ($page == $messages->currentPage())
                        <span class="page-number active">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="page-number">

                            {{ $page }}

                        </a>
                    @endif
                @endforeach


                {{-- NEXT --}}
                @if ($messages->hasMorePages())
                    <a href="{{ $messages->nextPageUrl() }}" class="page-btn">

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

    <!-- ================= MODAL DETAIL ================= -->

    <div id="detailModal" class="modal">

        <div class="modal-content">

            <div class="modal-header">

                <h2>Detail Aspirasi</h2>

                <span class="modal-close" onclick="closeDetailModal()">
                    &times;
                </span>

            </div>

            <div class="modal-body" id="detailBody">

            </div>

        </div>

    </div>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    window.statisticsUrl = "{{ route('admin.messages.statistics') }}";
    </script>
    <script src="{{ asset('js/admin/aspirasi.js') }}"></script>

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
@endpush
