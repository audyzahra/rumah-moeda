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
    {{-- ===================================== --}}
    {{-- ASPIRASI TERBARU & BERITA TERPOPULER --}}
    {{-- ===================================== --}}

    <div class="dashboard-grid">

        {{-- ================= ASPIRASI TERBARU ================= --}}
        <div class="dashboard-card">

            <div class="section-header">

                <h2>Aspirasi Terbaru</h2>

            </div>

            <div class="activity-list">

                @forelse($latestMessages as $item)
                    <div class="activity-item">

                        <div class="activity-icon message">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div class="activity-content">

                            <h4>{{ $item->full_name }}</h4>

                            <div class="activity-email">
                                {{ $item->email }}
                            </div>

                            <div class="activity-message">
                                {{ \Illuminate\Support\Str::limit($item->message, 45) }}
                            </div>

                            <div class="activity-date">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="fa-solid fa-envelope-open"></i>

                        <p>Belum ada aspirasi.</p>

                    </div>
                @endforelse

            </div>

        </div>


        {{-- ================= BERITA TERPOPULER ================= --}}
        <div class="dashboard-card">

            <div class="section-header">

                <h2>Berita Terpopuler</h2>

            </div>

            <div class="popular-news">

                @forelse($popularNews as $item)
                    <div class="popular-item">

                        <img src="{{ Storage::url($item->thumbnail) }}" class="popular-thumb" alt="{{ $item->title }}">

                        <div class="popular-content">

                            <span class="popular-category">

                                {{ $item->category->name ?? '-' }}

                            </span>

                            <h4>

                                {{ $item->title }}

                            </h4>

                            <div class="popular-meta">

                                <span>

                                    <i class="fa-solid fa-eye"></i>

                                    {{ number_format($item->views) }}

                                    Views

                                </span>

                                <span>

                                    {{ \Carbon\Carbon::parse($item->publish_date)->format('d M Y') }}

                                </span>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="fa-solid fa-newspaper"></i>

                        <p>Belum ada berita.</p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>

    <!-- Notifikasi -->
    <div id="notification" class="notification"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
