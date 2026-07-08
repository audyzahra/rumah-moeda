@extends('admin.layouts.app')

@section('title','Dashboard')

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
            <h4>Total Pengunjung</h4>
            <h2>25</h2>
            <small>+12% bulan ini</small>
        </div>
    </div>

    <div class="card">
        <div class="icon green">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <h4>Total Aspirasi</h4>
            <h2>482</h2>
            <small>18 Aspirasi Baru</small>
        </div>
    </div>

    <div class="card">
        <div class="icon purple">
            <i class="fa-solid fa-handshake"></i>
        </div>
        <div>
            <h4>Total Berita</h4>
            <h2>15</h2>
            <small>+5 berita baru</small>
        </div>
    </div>

    <div class="card">
        <div class="icon orange">
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div>
            <h4>Total Dokumentasi</h4>
            <h2>15</h2>
            <small>5 Foto Baru</small>
        </div>
    </div>

</section>

<!-- Tabel Aktivitas -->
<section class="table-section">

    <div class="section-header">
        <h2>Aspirasi Terbaru</h2>

        <button>
            Kelola Aspirasi
        </button>
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

            <tr>
                <td>Ahmad Fauzan</td>
                <td>ahmad@gmail.com</td>
                <td>Perbaikan Jalan</td>
                <td>12 Juni 2025</td>
                <td><span class="status baru">Baru</span></td>
            </tr>

            <tr>
                <td>Siti Nurhaliza</td>
                <td>siti@gmail.com</td>
                <td>Kegiatan Sosial</td>
                <td>11 Juni 2025</td>
                <td><span class="status proses">Diproses</span></td>
            </tr>

            <tr>
                <td>Budi Santoso</td>
                <td>budi@gmail.com</td>
                <td>Program UMKM</td>
                <td>10 Juni 2025</td>
                <td><span class="status selesai">Selesai</span></td>
            </tr>

            <tr>
                <td>Dewi Anggraini</td>
                <td>dewi@gmail.com</td>
                <td>Sampah Berserakan</td>
                <td>09 Juni 2025</td>
                <td><span class="status baru">Baru</span></td>
            </tr>

        </tbody>

    </table>

</section>

<!-- Notifikasi -->
<div id="notification" class="notification"></div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
