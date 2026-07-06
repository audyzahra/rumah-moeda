<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}">

    @stack('styles')

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    @include('admin.layouts.sidebar')

    <main class="main-content">
        @yield('content')
    </main>

    <script src="{{ asset('js/admin/app.js') }}"></script>

    @stack('scripts')

</body>

</html>
