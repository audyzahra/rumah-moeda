@extends('Layouts.app')

@section('title', $news->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail-berita.css') }}">
@endpush

@section('content')

    <section class="detail-container">

        <a href="{{ route('news.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Berita
        </a>

        <div class="artikel-header">

            <span class="kategori">
                {{ $news->category->name ?? 'Berita' }}
            </span>

            <h1>
                {{ $news->title }}
            </h1>

            <div class="artikel-meta">

                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ \Carbon\Carbon::parse($news->publish_date)->translatedFormat('d F Y') }}
                </span>

                <span>
                    <i class="fa-regular fa-user"></i>
                    {{ $news->author->name ?? 'Admin Rumah Moeda' }}
                </span>

            </div>

        </div>

        <div class="hero-image">

            @if ($news->thumbnail)
                <img src="{{ Storage::url($news->thumbnail) }}" alt="{{ $news->title }}">
            @else
                <img src="{{ asset('assets/no-image.png') }}" alt="No Image">
            @endif

        </div>

        <div class="artikel-content">

            {!! $news->content !!}

        </div>

    </section>



    <section class="artikel-lainnya">

        <h2>Berita Lainnya</h2>

        <div class="artikel-grid">

            @foreach ($otherNews as $item)
                <div class="artikel-card">

                    @if ($item->thumbnail)
                        <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}">
                    @else
                        <img src="{{ asset('assets/no-image.png') }}" alt="No Image">
                    @endif

                    <h3>
                        {{ Str::limit($item->title, 60) }}
                    </h3>

                    <a href="{{ route('news.show', $item->slug) }}">
                        Baca Selengkapnya →
                    </a>

                </div>
            @endforeach

        </div>

    </section>

@endsection
