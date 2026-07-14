@extends('user.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
@endpush

@section('content')

    <header class="topbar">

        <div class="topbar-left">

            <div>

                <h1>Beranda</h1>

                <p>
                    Selamat datang kembali,
                    <strong>{{ Auth::user()->name }}</strong> 👋
                </p>

            </div>

        </div>

    </header>


    {{-- ===========================
    CARD STATISTIK
=========================== --}}

    <section class="analytics">

        <div class="card">

            <div class="icon blue">
                <i class="fa-solid fa-newspaper"></i>
            </div>

            <div>

                <h4>Berita Saya</h4>

                <h2>{{ $totalNews }}</h2>

            </div>

        </div>

        <div class="card">

            <div class="icon orange">
                <i class="fa-solid fa-images"></i>
            </div>

            <div>

                <h4>Dokumentasi Saya</h4>

                <h2>{{ $totalGallery }}</h2>

            </div>

        </div>

        <div class="card">

            <div class="icon green">
                <i class="fa-solid fa-envelope"></i>
            </div>

            <div>

                <h4>Aspirasi Saya</h4>

                <h2>{{ $totalMessage }}</h2>

            </div>

        </div>

        <div class="card">

            <div class="icon purple">
                <i class="fa-solid fa-folder"></i>
            </div>

            <div>

                <h4>Total Konten Saya</h4>

                <h2>{{ $totalContent }}</h2>

            </div>

        </div>

    </section>


    {{-- ===========================
        CONTENT
    =========================== --}}

    <div class="dashboard-grid">

        {{-- ===================================== --}}
        {{-- AKTIVITAS TERBARU --}}
        {{-- ===================================== --}}

        <div class="dashboard-card">

            <div class="section-header">

                <h2>Aktivitas Terbaru</h2>

            </div>

            <div class="activity-list">
                {{-- ================= BERITA ================= --}}

                @foreach ($latestNews as $news)
                    <div class="activity-item">

                        <div class="activity-icon news">

                            <i class="fa-solid fa-newspaper"></i>

                        </div>

                        <div class="activity-content">

                            <h4>{{ $news->title }}</h4>

                            <small>

                                Berita • {{ $news->created_at->format('d M Y H:i') }}

                            </small>

                        </div>

                    </div>
                @endforeach


                {{-- ================= DOKUMENTASI ================= --}}

                @foreach ($latestGallery as $gallery)
                    <div class="activity-item">

                        <div class="activity-icon gallery">

                            <i class="fa-solid fa-images"></i>

                        </div>

                        <div class="activity-content">

                            <h4>{{ $gallery->title }}</h4>

                            <small>

                                Dokumentasi •
                                {{ $gallery->created_at->format('d M Y H:i') }}

                            </small>

                        </div>

                    </div>
                @endforeach


                {{-- ================= ASPIRASI ================= --}}

                @foreach ($latestMessages as $message)
                    <div class="activity-item">

                        <div class="activity-icon message">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        <div class="activity-content">

                            <h4>

                                {{ \Illuminate\Support\Str::limit($message->message, 60) }}

                            </h4>

                            <small>

                                Aspirasi •
                                {{ $message->created_at->format('d M Y H:i') }}

                            </small>

                        </div>

                    </div>
                @endforeach


                @if ($latestNews->isEmpty() && $latestGallery->isEmpty() && $latestMessages->isEmpty())
                    <div class="empty-state">

                        <i class="fa-solid fa-box-open"></i>

                        <p>

                            Belum ada aktivitas.

                        </p>

                    </div>
                @endif

            </div>

        </div>


        {{-- ===================================== --}}
        {{-- BERITA TERPOPULER --}}
        {{-- ===================================== --}}

        <div class="dashboard-card">

            <div class="section-header">
                <h2>Berita Terpopuler</h2>
            </div>

            @php
                $dummyViews = [1245, 986, 742, 631, 518];
            @endphp

            <div class="popular-news">

                @forelse($popularNews as $index => $item)
                    <div class="popular-item">

                        <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" class="popular-thumb">

                        <div class="popular-content">

                            <span class="popular-category">

                                {{ $item->category->name }}

                            </span>

                            <h4>

                                {{ $item->title }}

                            </h4>

                            <div class="popular-meta">

                                <span>

                                    <i class="fa-solid fa-eye"></i>

                                    {{ number_format($dummyViews[$index] ?? rand(200, 800)) }}

                                    Views

                                </span>

                                <span>

                                    {{ $item->publish_date->format('d M Y') }}

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
    {{-- ===========================
    NOTIFICATION
=========================== --}}

    <div id="notification" class="notification"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
