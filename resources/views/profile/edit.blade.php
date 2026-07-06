<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<body>

<div class="container-page">

    <div class="profile-card">

        <!-- PANEL KIRI -->
        <div class="profile-left">

            <a href="{{ url()->previous() }}" class="btn-back">
    <span>&larr;</span> Kembali
</a>

            <div class="left-content">

                <img src="{{ asset('assets/logorumahmoeda.png') }}" alt="Logo">

                <h1>Rumah Moeda</h1>

                <p>
                    Kelola informasi profil dan keamanan akun Anda.
                </p>

            </div>

        </div>

        <!-- PANEL KANAN -->
        <div class="profile-right">

            @if(session('status') === 'profile-updated')
                <div class="alert-success">
                    Profil berhasil diperbarui.
                </div>
            @endif

            <form method="POST" action="#">
                @csrf

                <h2>Profil Saya</h2>

                <div class="form-group">
                    <label>Nama</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                    >
                </div>

                <div class="form-group">
                    <label>Email</label>

                    <input
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        readonly
                    >
                </div>

                <div class="password-link">
    <a href="forgot-password.html">
        Ubah Password?
    </a>
</div>

                <button type="submit" class="btn-save">
                    Simpan
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>