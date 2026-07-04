<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Rumah Moeda</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                    Selamat datang kembali.
                    Silakan login untuk melanjutkan.
                </p>

            </div>

            <div class="right">

                <h2>Login</h2>

                {{-- Session Status --}}
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

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="input-group">

                        <i class="fa-solid fa-envelope"></i>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required
                            autofocus>

                    </div>

                    <div class="input-group">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password" id="password" name="password" placeholder="Password" required>

                        <span onclick="togglePassword('password','eye')">
                            <i class="fa-solid fa-eye" id="eye"></i>
                        </span>

                    </div>

                    <div style="margin-bottom:20px;">

                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">

                            <input type="checkbox" name="remember">

                            Ingat Saya

                        </label>

                    </div>

                    <div class="forgot">

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif

                    </div>

                    <button type="submit">
                        Login
                    </button>

                    <p>

                        Belum punya akun?

                        <a href="{{ route('register') }}">
                            Daftar
                        </a>

                    </p>

                </form>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
