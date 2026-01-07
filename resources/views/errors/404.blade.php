<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - {{ __('Səhifə tapılmadı') }} | {{ settings('site.title', 'VapeArt Baku') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ __('Axtardığınız səhifə tapılmadı. Ana səhifəyə qayıdın və ya axtarış edin.') }}">
    <meta name="robots" content="noindex, follow">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('storefront/images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storefront/images/favicon-32x32.png') }}">

    {{-- Theme Color --}}
    <meta name="theme-color" content="#000000">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .error-container {
            text-align: center;
            padding: 40px 20px;
            max-width: 600px;
        }

        .error-code {
            font-size: clamp(100px, 20vw, 180px);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            text-shadow: 0 0 40px rgba(102, 126, 234, 0.3);
        }

        .error-title {
            font-size: clamp(20px, 4vw, 28px);
            font-weight: 600;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .error-message {
            font-size: clamp(14px, 2.5vw, 16px);
            color: #a0aec0;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .search-box {
            margin-top: 40px;
            position: relative;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-box input::placeholder {
            color: #a0aec0;
        }

        .search-box input:focus {
            border-color: #667eea;
            background: rgba(255, 255, 255, 0.15);
        }

        .search-box svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #a0aec0;
        }

        .popular-links {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .popular-links h3 {
            font-size: 14px;
            font-weight: 500;
            color: #a0aec0;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .popular-links ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .popular-links a {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .popular-links a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">{{ __('Səhifə tapılmadı') }}</h1>
        <p class="error-message">
            {{ __('Axtardığınız səhifə mövcud deyil, silinib və ya köçürülüb. Zəhmət olmasa ana səhifəyə qayıdın.') }}
        </p>

        <div class="error-actions">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Ana səhifə') }}
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Geri qayıt') }}
            </a>
        </div>

        <form class="search-box" action="{{ route('products.index', ['locale' => app()->getLocale()]) }}" method="GET">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="search" placeholder="{{ __('Məhsul axtar...') }}">
        </form>

        <div class="popular-links">
            <h3>{{ __('Populyar səhifələr') }}</h3>
            <ul>
                <li><a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}">{{ __('Məhsullar') }}</a></li>
                <li><a href="{{ route('categories.index', ['locale' => app()->getLocale()]) }}">{{ __('Kateqoriyalar') }}</a></li>
                <li><a href="{{ route('brands.index', ['locale' => app()->getLocale()]) }}">{{ __('Brendlər') }}</a></li>
                <li><a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}">{{ __('Bloq') }}</a></li>
                <li><a href="{{ route('contacts.index', ['locale' => app()->getLocale()]) }}">{{ __('Əlaqə') }}</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
