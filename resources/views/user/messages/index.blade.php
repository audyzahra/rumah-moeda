@extends('user.layouts.app')

@section('title', 'Aspirasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/aspirasi.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->

    <div class="page-header">

        <h1>Aspirasi Saya</h1>

        <p>
            Lihat seluruh aspirasi yang pernah Anda kirim.
        </p>

    </div>

    <!-- ================= STATISTIK ================= -->

    <div class="aspirasi-stats">

        <div class="stat-card">

            <div class="stat-icon total">

                <i class="fa-solid fa-envelope"></i>

            </div>

            <div>

                <h4>Total Aspirasi</h4>

                <h2>{{ $totalMessages }}</h2>

            </div>

        </div>

    </div>

    <!-- ================= FILTER ================= -->

    <div class="filter-section">

        <div class="filter-left">

            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau email...">

        </div>

    </div>

    <!-- ================= TABLE ================= -->

    <div class="table-section">

        <div class="table-wrapper">

            <table id="aspirasiTable">

                <thead>

                    <tr>

                        <th>Nama</th>

                        <th>Email</th>

                        <th>No. Telepon</th>

                        <th>Pesan</th>

                        <th>Tanggal</th>

                        <th>Status</th>

                        <th width="80">Aksi</th>

                    </tr>

                </thead>

                <tbody id="aspirasiBody">

                    @forelse($messages as $message)
                        <tr data-name="{{ strtolower($message->full_name) }}"
                            data-email="{{ strtolower($message->email) }}">

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

                                {{ \Illuminate\Support\Str::limit($message->message, 60) }}

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
                                    {{-- Tombol Detail --}}
                                    <button class="btn-detail" data-id="{{ $message->id }}"
                                        data-name="{{ $message->full_name }}" data-email="{{ $message->email }}"
                                        data-phone="{{ $message->phone }}" data-message="{{ $message->message }}"
                                        data-status="{{ $message->is_read }}"
                                        data-created="{{ $message->created_at->format('d M Y H:i') }}"
                                        onclick="showDetail(this)">

                                        <i class="fa-solid fa-eye"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" style="text-align:center;padding:30px;">

                                Anda belum pernah mengirim aspirasi.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- ================= PAGINATION ================= -->

        <div class="pagination-section">

            <div class="info-data">

                Menampilkan

                <span id="startData">0</span>

                -

                <span id="endData">0</span>

                dari

                <span id="totalData">0</span>

                data

            </div>

            <div class="pagination-controls">

                <button class="page-btn" id="prevBtn" onclick="prevPage()">

                    <i class="fa-solid fa-chevron-left"></i>

                </button>

                <span id="pageInfo">

                    Halaman 1

                </span>

                <button class="page-btn" id="nextBtn" onclick="nextPage()">

                    <i class="fa-solid fa-chevron-right"></i>

                </button>

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

    <!-- ================= NOTIFICATION ================= -->

    <div id="notification" class="notification">

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/aspirasi.js') }}"></script>
@endpush
