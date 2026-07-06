<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <div class="container-page">

        <div class="profile-card">

            <!-- PANEL KIRI -->
            <div class="profile-left">

                <a href="{{ url('/') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
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

                @if (session('status') === 'profile-updated')
                    <div class="alert-success">
                        Profil berhasil diperbarui.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    @csrf

                    <h2>Profil Saya</h2>

                    <div class="form-group">

                        <label>Nama</label>

                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input type="email" value="{{ $user->email }}" readonly disabled>

                    </div>

                    <a href="{{ route('password.request') }}">
                        Ubah Password?
                    </a>

                    <button type="submit" class="btn-save">
                        Simpan
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
