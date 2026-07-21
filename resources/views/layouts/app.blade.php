<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Rumah Moeda')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    {{-- JS --}}
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/darkmode.js') }}"></script>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (auth()->check() && auth()->user()->role == 'user')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dashboardBtn = document.getElementById('dashboardBtn');

                if (dashboardBtn) {
                    dashboardBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Selamat Datang 👋',
                            html: `
        <div style="padding:10px 0 5px;">
            <h2 style="
                margin:0;
                color:#222;
                font-weight:700;
                font-size:28px;
            ">
                Halo, {{ auth()->user()->name }}
            </h2>

            <p style="
                margin:18px 0 0;
                color:#666;
                font-size:16px;
                line-height:1.6;
            ">
                Terima kasih telah kembali.<br>
                Dashboard sedang dipersiapkan...
            </p>
        </div>
    `,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            background: '#fff',
                            width: 450,
                            padding: '2rem',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        }).then(() => {
                            window.location.href = "{{ route('user.dashboard') }}";
                        });
                    });
                }
            });
        </script>
    @endif

</body>

</html>
