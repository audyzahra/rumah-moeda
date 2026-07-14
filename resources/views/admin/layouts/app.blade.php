<!DOCTYPE html>
<html lang="id">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Admin Rumah Moeda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Sidebar -->
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">

    @stack('styles')

</head>

<body>

<div class="admin-wrapper">

    @include('admin.partials.sidebar')

    <main class="main-content">

        @yield('content')

    </main>

</div>

<script src="{{ asset('js/admin/sidebar.js') }}"></script>

@stack('scripts')

</body>

</html>
<style>
.admin-wrapper{
    display:flex;
}

.main-content{
    margin-left:270px;
    width:calc(100% - 270px);
    min-height:100vh;
    padding:35px;
    background:#f8f9fc;
    box-sizing:border-box;
}

/* Tablet */
@media(max-width:992px){
    .main-content{
        margin-left:220px;
        width:calc(100% - 220px);
    }
}

/* Mobile */
@media(max-width:768px){
    .main-content{
        margin-left:0;
        width:100%;
        padding:20px;
    }
}
</style>
