<title>{{ $title ?? 'Rumah Moeda' }}</title>

<meta name="description" content="{{ $description ?? 'Website resmi Rumah Moeda' }}">

<meta name="keywords" content="{{ $keywords ?? 'Rumah Moeda' }}">

<meta name="author" content="Rumah Moeda">

<meta name="robots" content="index, follow">

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:title" content="{{ $title ?? 'Rumah Moeda' }}">
<meta property="og:description" content="{{ $description ?? 'Website resmi Rumah Moeda' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('images/logo.png') }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? 'Rumah Moeda' }}">
<meta name="twitter:description" content="{{ $description ?? 'Website resmi Rumah Moeda' }}">
<meta name="twitter:image" content="{{ asset('images/logo.png') }}">
