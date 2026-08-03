<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Akses Ditolak</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .error-box {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.1);
        }

        .error-code {
            font-size: 90px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>

</head>

<body>

<div class="error-box">

    <div class="error-code">
        403
    </div>

    <h3>
        Halaman Tidak Dapat Diakses
    </h3>

    <p class="text-muted">
        Maaf, Anda tidak memiliki izin untuk membuka halaman ini.
    </p>

    <p>
        Anda akan diarahkan ke halaman utama dalam
        <b id="countdown">3</b> detik.
    </p>


    <a href="{{ route('home') }}" class="btn btn-primary">
        Kembali ke Home
    </a>

</div>


<script>

let waktu = 3;

let countdown = document.getElementById('countdown');


let timer = setInterval(function(){

    waktu--;

    countdown.innerHTML = waktu;


    if(waktu <= 0){

        clearInterval(timer);

        window.location.href = "{{ $redirect ?? route('home') }}";
    }

},1000);


</script>


</body>

</html>
