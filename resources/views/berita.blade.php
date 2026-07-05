@extends('Layouts.app')

@section('title', 'Berita')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('content')

<div class="berita-header">

    <div>

        <h1>Berita Rumah Moeda</h1>

        <p>
            Informasi terbaru mengenai kegiatan Rumah Moeda.
        </p>

    </div>

</div>


<section class="berita-list">

    @forelse($news as $item)

    <div class="berita-card">

        <img src="{{ asset($item->thumbnail) }}"
             alt="{{ $item->title }}">

        <div class="berita-content">

            <div class="meta">

                <span>

                    <i class="fa-solid fa-tag"></i>

                    {{ $item->category->name }}

                </span>

                <span>

                    <i class="fa-regular fa-calendar"></i>

                    {{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('d F Y') }}

                </span>

            </div>

            <h2>

                {{ $item->title }}

            </h2>

            <p>

                {{ Str::limit(strip_tags($item->content), 220) }}

            </p>

            <div class="action">

                <a href="{{ route('berita.show', $item->slug) }}">

                    Baca Selengkapnya →

                </a>

            </div>

        </div>

    </div>

    @empty

    <div style="text-align:center;padding:60px;">

        <h3>Belum ada berita.</h3>

    </div>

    @endforelse

</section>

@endsection
