<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Rumah Moeda</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    <div class="container">

        <div class="card">

            <div class="left">

                <div class="logo">
                    <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo Rumah Moeda">
                </div>

                <h1 class="register-title">Rumah Moeda</h1>

                <p>
                    Buat akun baru dan bergabung bersama Rumah Moeda.
                </p>

            </div>

            <div class="right">

                <h2>Registrasi</h2>

                {{-- Success Message --}}
                @if (session('status'))
                    <div style="background:#d4edda;color:#155724;padding:12px;border-radius:10px;margin-bottom:20px;">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Validation Error --}}
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

                    </div>

                    {{-- Confirm Password --}}
                    <div class="input-group">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password" id="password" name="password" placeholder="Password" required>

                        <span onclick="togglePassword('password','eye')">
                            <i class="fa-solid fa-eye" id="eye"></i>
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

</body>

</html>
