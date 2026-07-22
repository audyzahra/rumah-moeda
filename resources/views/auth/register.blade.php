<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Rumah Moeda</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    <div class="container">

        <div class="card">

            <div class="left">

                <a href="{{ url('/') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div class="logo">
                    <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo Rumah Moeda">
                </div>

                <h1 class="register-title">
                    Rumah Moeda
                </h1>

                <p>
                    Buat akun baru dan bergabung bersama Rumah Moeda.
                </p>

            </div>

            <div class="right">

                <h2>Registrasi</h2>

                {{-- Success --}}
                @if (session('status'))
                    <div style="background:#d4edda;color:#155724;padding:12px;border-radius:10px;margin-bottom:20px;">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error --}}
                @if ($errors->any())
                    <div style="background:#f8d7da;color:#721c24;padding:12px;border-radius:10px;margin-bottom:20px;">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">

                    @csrf

                    {{-- Username --}}
                    <div class="input-group">

                        <i class="fa-solid fa-user"></i>

                        <input type="text" id="username" name="name" placeholder="Username"
                            value="{{ old('name') }}" required autofocus>

                    </div>

                    {{-- Email --}}
                    <div class="input-group">

                        <i class="fa-solid fa-envelope"></i>

                        <input type="email" id="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" required>

                    </div>

                    {{-- Password --}}
                    <div class="input-group">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password" id="password" name="password" placeholder="Password" required>

                        <span onclick="togglePassword('password','eye1')">
                            <i class="fa-solid fa-eye" id="eye1"></i>
                        </span>

                    </div>
                    <div class="password-rules">

                        <p>Password harus memenuhi:</p>

                        <ul>

                            <li id="rule-length">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Minimal 8 karakter
                            </li>

                            <li id="rule-upper">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Huruf besar
                            </li>

                            <li id="rule-lower">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Huruf kecil
                            </li>

                            <li id="rule-number">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Angka
                            </li>

                            <li id="rule-symbol">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Simbol
                            </li>

                        </ul>

                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="input-group">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi Password" required>

                        <span onclick="togglePassword('password_confirmation','eye2')">
                            <i class="fa-solid fa-eye" id="eye2"></i>
                        </span>

                    </div>

                    <button type="submit">

                        Daftar

                    </button>

                    <p>

                        Sudah punya akun?

                        <a href="{{ route('login') }}">
                            Login
                        </a>

                    </p>

                </form>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        const password = document.getElementById('password');

        password.addEventListener('keyup', function() {

            const value = this.value;

            validateRule(
                "rule-length",
                value.length >= 8
            );

            validateRule(
                "rule-upper",
                /[A-Z]/.test(value)
            );

            validateRule(
                "rule-lower",
                /[a-z]/.test(value)
            );

            validateRule(
                "rule-number",
                /\d/.test(value)
            );

            validateRule(
                "rule-symbol",
                /[^A-Za-z0-9]/.test(value)
            );

        });

        function validateRule(id, valid) {

            const item = document.getElementById(id);

            const icon = item.querySelector("i");

            if (valid) {

                item.classList.remove("invalid");
                item.classList.add("valid");

                icon.className = "fa-solid fa-circle-check";

            } else {

                item.classList.remove("valid");
                item.classList.add("invalid");

                icon.className = "fa-solid fa-circle-xmark";

            }

        }
    </script>
</body>

</html>
