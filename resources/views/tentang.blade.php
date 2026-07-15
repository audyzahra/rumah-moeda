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

                <img src="{{ Storage::url($settings->website_logo) }}" alt="{{ $settings->website_name }}">

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

                    @foreach ($vision->missions as $mission)
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
                $parents = $organizations->whereNull('parent_id');
            @endphp

            @foreach ($parents as $parent)
                <div class="leader-wrapper">
                    <div class="leader-card">

                        <img src="{{ $parent->photo_url }}" alt="{{ $parent->full_name }}">

                        <h3>{{ $parent->full_name }}</h3>

                        <span>{{ $parent->position }}</span>

                    </div>
                </div>

                @php
                    $children = $organizations->where('parent_id', $parent->id);
                @endphp

                @if ($children->count())
                    <div class="connector-line"></div>

                    <div class="member-grid">

                        @foreach ($children as $item)
                            <div class="member-card">

                                <img src="{{ $item->photo_url }}" alt="{{ $item->full_name }}">

                                <h4>{{ $item->full_name }}</h4>

                                <p>{{ $item->position }}</p>

                            </div>
                        @endforeach

                    </div>
                @endif
            @endforeach

        </section>

    </main>

@endsection
