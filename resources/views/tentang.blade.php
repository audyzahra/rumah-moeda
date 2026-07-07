@extends('Layouts.app')

@section('title', 'Tentang Kami')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tentang.css') }}">
@endpush

@section('content')

<main class="container-page">

    {{-- ================= PROFIL ================= --}}
    <section class="profil-pendiri">

        <h2>Profil Rumah Moeda</h2>

        <div class="pendiri-card">

            <img src="{{ asset($settings->website_logo) }}"
                 alt="{{ $settings->website_name }}">

            <h3>{{ $settings->website_name }}</h3>

            <p>
                {{ $settings->website_description }}
            </p>

        </div>

    </section>


    {{-- ================= VISI MISI ================= --}}
    <section class="visi-misi-lengkap">

        <h2>Visi & Misi</h2>

        <div class="visi-box">

            <h3>Visi</h3>

            <p>
                {{ $vision->vision }}
            </p>

        </div>

        <div class="misi-box">

            <h3>Misi</h3>

            <ul>

                @foreach($vision->missions as $mission)

                    <li>
                        {{ $mission->mission }}
                    </li>

                @endforeach

            </ul>

        </div>

    </section>


   {{-- ================= STRUKTUR ================= --}}
<section class="struktur-section">

    <h2 class="section-title">
        Struktur Organisasi
    </h2>

    <p class="section-subtitle">
        Sinergi para profesional untuk menciptakan dampak sosial yang nyata.
    </p>

    @php
        $ketua = $organizations->where('display_order',1)->first();
        $anggota = $organizations->where('display_order','>',1);
    @endphp

    {{-- Ketua --}}
    @if($ketua)
    <div class="leader-wrapper">

        <div class="leader-card">

            <img src="{{ asset('storage/' . $ketua->photo) }}"
                alt="{{ $ketua->full_name }}">

            <h3>{{ $ketua->full_name }}</h3>

            <span>{{ $ketua->position }}</span>

        </div>

    </div>
    @endif

    {{-- Garis --}}
    <div class="connector-line"></div>

    {{-- Anggota --}}
    <div class="member-grid">

        @foreach($anggota as $item)

        <div class="member-card">

           <img src="{{ asset('storage/' . $item->photo) }}"
                alt="{{ $item->full_name }}">

            <h4>{{ $item->full_name }}</h4>

            <p>{{ $item->position }}</p>

        </div>

        @endforeach

    </div>

</section>

</main>

@endsection
