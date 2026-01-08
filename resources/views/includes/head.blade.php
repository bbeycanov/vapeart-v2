<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="author" content="VapeArt Baku">

{{-- Google Analytics --}}
@if(config('services.google.analytics_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ config('services.google.analytics_id') }}');
</script>
@endif

{{-- SEO Meta Tags --}}
<meta name="description" content="@hasSection('meta_description')@yield('meta_description')@else{{ settings('site.description', 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası.') }}@endif">
<meta name="keywords" content="@hasSection('meta_keywords')@yield('meta_keywords')@else{{ settings('site.keywords', 'vape, elektron siqaret, snus, tütün, vape baku') }}@endif">

{{-- Robots Meta Tag - noindex for filtered/sorted pages to prevent duplicate content --}}
@php
    $filterParams = ['sort', 'order', 'filter', 'brand_id', 'category_id', 'min_price', 'max_price', 'page', 'per_page', 'q', 'search'];
    $hasFilterParams = collect($filterParams)->contains(fn($param) => request()->has($param));
    $robotsContent = $hasFilterParams ? 'noindex, follow' : 'index, follow';
@endphp
<meta name="robots" content="@hasSection('robots')@yield('robots')@else{{ $robotsContent }}@endif">

{{-- Canonical URL - always point to clean URL without filter params --}}
@php
    $canonicalUrl = url()->current();
    // Remove query parameters for canonical
    $cleanCanonical = strtok($canonicalUrl, '?');
@endphp
<link rel="canonical" href="@hasSection('canonical')@yield('canonical')@else{{ $cleanCanonical }}@endif">

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
<meta property="og:image" content="@hasSection('og_image')@yield('og_image')@else{{ asset('storefront/images/placeholder-og.jpg') }}@endif">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@hasSection('title')@yield('title') | {{ settings('site.title', 'VapeArt Baku') }}@else{{ settings('site.title', 'VapeArt Baku') }}@endif">
<meta name="twitter:description" content="@hasSection('meta_description')@yield('meta_description')@else{{ settings('site.description', 'VapeArt Baku - Bakıda elektron siqaretlər, vape cihazları, snus və premium tütün məhsulları mağazası.') }}@endif">
<meta name="twitter:image" content="@hasSection('og_image')@yield('og_image')@else{{ asset('storefront/images/placeholder-og.jpg') }}@endif">

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

{{-- Toastr Custom Styles (moved from inline) --}}
<link rel="stylesheet" href="{{ asset('storefront/css/includes/toastr-custom.css') }}" type="text/css">
