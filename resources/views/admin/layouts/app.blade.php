<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Admin Rumah Moeda</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Sidebar -->
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}">

    @stack('styles')

</head>

<body>

    @include('admin.partials.sidebar')

    <main class="main-content">

        @yield('content')

    </main>

    <!-- Sidebar -->
    <script src="{{ asset('js/admin/sidebar.js') }}"></script>

    @stack('scripts')

</body>

</html>
