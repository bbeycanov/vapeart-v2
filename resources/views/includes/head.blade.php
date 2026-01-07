<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="author" content="VapeArt Baku">

{{-- SEO Meta Tags --}}
<meta name="description" content="@hasSection('meta_description')@yield('meta_description')@else{{ settings('site.description', 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası.') }}@endif">
<meta name="keywords" content="@hasSection('meta_keywords')@yield('meta_keywords')@else{{ settings('site.keywords', 'vape, elektron siqaret, snus, tütün, vape baku') }}@endif">
<meta name="robots" content="@hasSection('robots')@yield('robots')@else{{ 'index, follow' }}@endif">

{{-- Canonical URL --}}
<link rel="canonical" href="@hasSection('canonical')@yield('canonical')@else{{ url()->current() }}@endif">

{{-- Hreflang Tags for Multilingual SEO --}}
@php
    $activeLanguages = \App\Models\Language::where('is_active', true)->pluck('code')->toArray();
    $currentRoute = request()->route();
    $currentRouteName = $currentRoute ? $currentRoute->getName() : null;
    $currentParams = $currentRoute ? $currentRoute->parameters() : [];
@endphp
@foreach($activeLanguages as $langCode)
    @php
        $alternateUrl = $currentRouteName
            ? route($currentRouteName, array_merge($currentParams, ['locale' => $langCode]))
            : url("/{$langCode}");
    @endphp
    <link rel="alternate" hreflang="{{ $langCode }}" href="{{ $alternateUrl }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ url('/'.config('app.locale', 'az')) }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:site_name" content="{{ settings('site.title', 'VapeArt Baku') }}">
<meta property="og:locale" content="{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}">
<meta property="og:type" content="@hasSection('og_type')@yield('og_type')@else{{ 'website' }}@endif">
<meta property="og:title" content="@hasSection('title')@yield('title') | {{ settings('site.title', 'VapeArt Baku') }}@else{{ settings('site.title', 'VapeArt Baku') }}@endif">
<meta property="og:description" content="@hasSection('meta_description')@yield('meta_description')@else{{ settings('site.description', 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası.') }}@endif">
<meta property="og:url" content="@hasSection('canonical')@yield('canonical')@else{{ url()->current() }}@endif">
<meta property="og:image" content="@hasSection('og_image')@yield('og_image')@else{{ asset(settings('site.og_image', 'storefront/images/og-image.jpg')) }}@endif">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@hasSection('title')@yield('title') | {{ settings('site.title', 'VapeArt Baku') }}@else{{ settings('site.title', 'VapeArt Baku') }}@endif">
<meta name="twitter:description" content="@hasSection('meta_description')@yield('meta_description')@else{{ settings('site.description', 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası.') }}@endif">
<meta name="twitter:image" content="@hasSection('og_image')@yield('og_image')@else{{ asset(settings('site.og_image', 'storefront/images/og-image.jpg')) }}@endif">

{{-- Favicon & Icons --}}
<link rel="shortcut icon" href="{{ asset('storefront/images/favicon.ico') }}" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storefront/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storefront/images/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storefront/images/apple-touch-icon.png') }}">

{{-- Web App Manifest (PWA) --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">

{{-- Theme Color --}}
<meta name="theme-color" content="#000000">
<meta name="msapplication-TileColor" content="#000000">

{{-- Preconnect for Performance --}}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.googleapis.com">

{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter%3A300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;subset=latin&#038;display=swap&#038;ver=6.8.3" type="text/css" media="all">

{{-- CSS Plugins --}}
<link rel="stylesheet" href="{{ asset('storefront/css/plugins/swiper.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('storefront/css/plugins/jquery.fancybox.css') }}" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css">

{{-- Main CSS --}}
<link rel="stylesheet" href="{{ asset('storefront/css/style.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('storefront/css/pages/cart-index.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('storefront/css/includes/site-map.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('storefront/css/includes/footer.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('storefront/css/includes/quick-view.css') }}" type="text/css">

{{-- Inline Styles --}}
<style>
    * {
        font-family: "Inter", Arial, Helvetica, sans-serif !important;
    }
    /* Toastr Success - Green */
    .toast-success {
        background-color: #51A351 !important;
        color: #ffffff !important;
    }
    /* Toastr Error - Red */
    .toast-error {
        background-color: #BD362F !important;
        color: #ffffff !important;
    }
    /* Toastr Warning - Orange */
    .toast-warning {
        background-color: #F89406 !important;
        color: #ffffff !important;
    }
    /* Toastr Info - Blue */
    .toast-info {
        background-color: #2F96B4 !important;
        color: #ffffff !important;
    }
    /* Toastr Title */
    #toast-container > div .toast-title {
        color: #ffffff !important;
        font-weight: bold;
    }
    /* Toastr Message */
    #toast-container > div .toast-message {
        color: #ffffff !important;
    }
    /* Toastr Close Button */
    #toast-container > div .toast-close-button {
        color: #ffffff !important;
        opacity: 0.8;
    }
    #toast-container > div .toast-close-button:hover {
        opacity: 1;
    }
</style>
