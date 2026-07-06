<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password | Rumah Moeda</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <div class="card">

        <div class="left">

            <div class="logo">
                <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo Rumah Moeda">
            </div>

            <h1>Rumah Moeda</h1>

            <p>
                Masukkan email yang terdaftar.
                Kami akan mengirimkan link untuk mengatur ulang password Anda.
            </p>

        </div>

        <div class="right">

            <h2>Lupa Password</h2>

            {{-- Pesan Berhasil --}}
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('password.email') }}"
                id="forgotForm"
            >

                @csrf

                <div class="input-group">

                    <i class="fa-solid fa-envelope"></i>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan Email"
                        required
                        autofocus
                    >

                </div>

                <button type="submit">

                    Kirim Link Reset

                </button>

                <p>

                    Kembali ke

                    <a href="{{ route('login') }}">

                        Login

                    </a>

                </p>

            </form>

        </div>

    </div>

</div>

<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
