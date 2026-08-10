{{-- SEO Basic --}}

<title>{{ $title }}</title>

<meta
    name="description"
    content="{{ $description }}"
>

<meta
    name="keywords"
    content="{{ $keywords }}"
>

<meta
    name="author"
    content="{{ $setting->website_name ?? 'Rumah Moeda' }}"
>

{{-- Open Graph --}}

<meta
    property="og:title"
    content="{{ $title }}"
>

<meta
    property="og:description"
    content="{{ $description }}"
>

<meta
    property="og:url"
    content="{{ url()->current() }}"
>

<meta
    property="og:type"
    content="website"
>

@if (!empty($setting?->website_logo))
    <meta
        property="og:image"
        content="{{ asset('storage/' . $setting->website_logo) }}"
    >
@endif

{{-- Twitter --}}

<meta
    name="twitter:card"
    content="summary_large_image"
>

<meta
    name="twitter:title"
    content="{{ $title }}"
>

<meta
    name="twitter:description"
    content="{{ $description }}"
>

@if (!empty($setting?->website_logo))
    <meta
        name="twitter:image"
        content="{{ asset('storage/' . $setting->website_logo) }}"
    >
@endif
