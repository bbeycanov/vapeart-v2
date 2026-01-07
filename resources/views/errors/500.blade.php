<!DOCTYPE html>
<html dir="ltr" lang="az">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server xətası | VapeArt Baku</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="Serverdə xəta baş verdi. Bir neçə dəqiqə sonra yenidən cəhd edin.">
    <meta name="robots" content="noindex, nofollow">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="/storefront/images/favicon.ico" type="image/x-icon">

    {{-- Theme Color --}}
    <meta name="theme-color" content="#000000">

    {{-- Fonts - using system fonts as fallback for reliability --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #2d1f3d 0%, #1a1a2e 50%, #16213e 100%);
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
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 40px rgba(229, 62, 62, 0.3);
        }

        .error-icon svg {
            width: 60px;
            height: 60px;
            color: #ffffff;
        }

        .error-code {
            font-size: clamp(60px, 15vw, 100px);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
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
            cursor: pointer;
            border: none;
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

        .status-info {
            margin-top: 50px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-info p {
            font-size: 13px;
            color: #718096;
            margin-bottom: 8px;
        }

        .status-info p:last-child {
            margin-bottom: 0;
        }

        .contact-link {
            color: #667eea;
            text-decoration: none;
        }

        .contact-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <div class="error-code">500</div>
        <h1 class="error-title">Server xətası</h1>
        <p class="error-message">
            Üzr istəyirik, serverdə gözlənilməz xəta baş verdi. Texniki komandamız məsələ üzərində işləyir.
            Zəhmət olmasa bir neçə dəqiqə sonra yenidən cəhd edin.
        </p>

        <div class="error-actions">
            <a href="/" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Ana səhifə
            </a>
            <button onclick="location.reload()" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Yenilə
            </button>
        </div>

        <div class="status-info">
            <p>Problem davam edərsə, bizimlə əlaqə saxlayın:</p>
            <p><a href="mailto:info@vapeart.az" class="contact-link">info@vapeart.az</a></p>
        </div>
    </div>
</body>
</html>
