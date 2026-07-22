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

                <div>
                    {!! $setting->website_description !!}
                </div>

            </div>

        </section>


        {{-- ================= VISI MISI ================= --}}
        <section class="visi-misi-lengkap">

            <h2>Visi & Misi</h2>

            <div class="visi-box">

                <h3>Visi</h3>

                <div class="vision-text">
                    {!! $vision->vision !!}
                </div>

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

            <div class="organization-wrapper">
                <div id="organization-chart"></div>
            </div>

        </section>

    </main>

@endsection


@push('scripts')
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script id="organization-data" type="application/json">
@json($organizations)
</script>

    <script src="{{ asset('js/organization-chart.js') }}"></script>

    <script src="{{ asset('js/home.js') }}"></script>
@endpush
