<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - {{ __('Giriş qadağandır') }} | {{ settings('site.title', 'VapeArt Baku') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ __('Bu səhifəyə giriş qadağandır.') }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('storefront/images/favicon.ico') }}" type="image/x-icon">

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
            max-width: 550px;
        }

        .error-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 40px rgba(237, 137, 54, 0.3);
        }

        .error-icon svg {
            width: 50px;
            height: 50px;
            color: #ffffff;
        }

        .error-code {
            font-size: clamp(80px, 18vw, 140px);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #fbd38d 0%, #ed8936 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
        }

        .error-title {
            font-size: clamp(20px, 4vw, 26px);
            font-weight: 600;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .error-message {
            font-size: clamp(14px, 2.5vw, 16px);
            color: #a0aec0;
            margin-bottom: 40px;
            line-height: 1.7;
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
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <div class="error-code">403</div>
        <h1 class="error-title">{{ __('Giriş qadağandır') }}</h1>
        <p class="error-message">
            {{ __('Bu səhifəyə giriş icazəniz yoxdur. Əgər bu xəta olduğunu düşünürsünüzsə, bizimlə əlaqə saxlayın.') }}
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
    </div>
</body>
</html>
