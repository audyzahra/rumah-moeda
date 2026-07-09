@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')

    <header class="topbar">
        <div class="topbar-left">
            <div>
                <h1>Beranda</h1>
                <p>Selamat datang di Beranda Admin Rumah Moeda</p>
            </div>
        </div>

        <div class="profile">

        </div>
    </header>

    <!-- Statistik -->
    <section class="analytics">

        <div class="card">
            <div class="icon blue">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <h4>Total Mitra</h4>

                <h2>{{ $totalPartner }}</h2>

                <small>Mitra Terdaftar</small>
            </div>
        </div>

        <div class="card">
            <div class="icon green">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h4>Total Aspirasi</h4>

                <h2>{{ $totalAspirasi }}</h2>

                <small>{{ $aspirasiBaru }} Belum Dibaca</small>
            </div>
        </div>

        <div class="card">
            <div class="icon purple">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
                <h4>Total Berita</h4>

                <h2>{{ $totalNews }}</h2>

                <small>{{ $beritaBaru }} Berita Baru</small>
            </div>
        </div>

        <div class="card">
            <div class="icon orange">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <h4>Total Dokumentasi</h4>

                <h2>{{ $totalGallery }}</h2>

                <small>{{ $galleryBaru }} Dokumentasi Baru</small>
            </div>
        </div>

    </section>

    <!-- Tabel Aktivitas -->
    <section class="table-section">

        <div class="section-header">
            <h2>Aspirasi Terbaru</h2>

            <a href="{{ route('admin.aspirasi.index') }}" class="btn-kelola">

                Kelola Aspirasi

            </a>
        </div>

        <table>

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($latestMessages as $item)
                    <tr>

                        <td>{{ $item->full_name }}</td>

                        <td>{{ $item->email }}</td>

                        <td>{{ \Illuminate\Support\Str::limit($item->message, 40) }}</td>

                        <td>{{ $item->created_at->format('d M Y') }}</td>

                        <td>

                            @if ($item->is_read)
                                <span class="status selesai">

                                    Dibaca

                                </span>
                            @else
                                <span class="status baru">

                                    Belum Dibaca

                                </span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" style="text-align:center">

                            Belum ada aspirasi.

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </section>

    <!-- Notifikasi -->
    <div id="notification" class="notification"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
