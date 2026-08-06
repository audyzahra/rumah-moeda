<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email | Rumah Moeda</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f5f7fb;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .verify-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .verify-title {
            font-size: 28px;
            font-weight: 700;
            color: #222;
            margin-bottom: 20px;
        }

        .verify-text {
            color: #666;
            line-height: 1.8;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .verify-success {
            background: #e8f8ee;
            color: #2e7d32;
            border: 1px solid #b7e4c7;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .verify-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #F4B400;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .verify-btn:hover {
            background: #d99c00;
        }

        .logout-btn {
            width: 100%;
            margin-top: 15px;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #fff;
            color: #555;
            font-size: 15px;
            cursor: pointer;
            transition: .3s;
        }

        .logout-btn:hover {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="verify-card">

        <h2 class="verify-title">Verifikasi Email</h2>

        <p class="verify-text">
            Terima kasih telah mendaftar di <strong>Rumah Moeda</strong>.<br><br>
            Kami telah mengirimkan email verifikasi ke alamat email Anda.
            Silakan buka email tersebut, lalu klik tombol <strong>Verify Email Address</strong>
            agar akun Anda dapat digunakan.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="verify-success">
                Link verifikasi berhasil dikirim ulang ke email Anda.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify-btn">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Keluar
            </button>
        </form>

    </div>

</body>

</html>