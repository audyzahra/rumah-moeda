<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | Rumah Moeda</title>

    <link rel="stylesheet" href="{{ asset('css/auth/reset-password.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <div class="logo">

        <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo Rumah Moeda">

    </div>

    <div class="card">

        <h2>Reset Password</h2>

        <p>
            Silakan masukkan password baru Anda.
        </p>

        {{-- Success --}}
        @if(session('status'))

            <div class="alert-success">

                {{ session('status') }}

            </div>

        @endif

        {{-- Error Validation --}}
        @if($errors->any())

            <div class="alert-danger">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            method="POST"
            action="{{ route('password.store') }}"
        >

            @csrf

            {{-- Token Reset Password --}}
            <input
                type="hidden"
                name="token"
                value="{{ $request->route('token') }}"
            >

            {{-- Email --}}
            <div class="input-box">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', request()->email) }}"
                    readonly
                    required
                >

            </div>

            {{-- Password Baru --}}
            <div class="input-box">

                <label>Password Baru</label>

                <div class="password">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan Password Baru"
                        required
                    >

                    <i
                        class="fa-solid fa-eye"
                        id="eye1"
                        onclick="togglePassword('password','eye1')"
                    ></i>

                </div>

            </div>

            {{-- Konfirmasi Password --}}
            <div class="input-box">

                <label>Konfirmasi Password</label>

                <div class="password">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Konfirmasi Password"
                        required
                    >

                    <i
                        class="fa-solid fa-eye"
                        id="eye2"
                        onclick="togglePassword('password_confirmation','eye2')"
                    ></i>

                </div>

            </div>

            <button type="submit">

                RESET PASSWORD

            </button>

        </form>

    </div>

</div>

<script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
