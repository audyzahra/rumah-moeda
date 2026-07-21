@extends('Layouts.app')

@section('title', 'Hubungi Kami')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hubungi.css') }}">
@endpush

@section('content')

<main class="contact-container">

    <h2>Hubungi Kami</h2>

    <p>
        Punya pertanyaan atau ingin bekerja sama?
        Kirimkan pesanmu di bawah ini.
    </p>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Error --}}
    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">

        @csrf

        <div class="form-group">

            <label for="full_name">
                Nama Lengkap
            </label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name') }}"
                placeholder="Masukkan nama Anda"
                required>

        </div>

        <div class="form-group">

            <label for="phone">
                No. Telepon
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Contoh: 08123456789"
                required>

        </div>

        <div class="form-group">

            <label for="email">
                Alamat Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required>

        </div>

        <div class="form-group">

            <label for="message">
                Isi Pesan
            </label>

            <textarea
                id="message"
                name="message"
                rows="6"
                placeholder="Tuliskan pesan Anda di sini..."
                required>{{ old('message') }}</textarea>

        </div>

        <button type="submit" class="btn-submit">
            Kirim Pesan
        </button>

    </form>

</main>

@endsection
