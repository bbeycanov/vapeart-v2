<!DOCTYPE html>
<html dir="ltr" lang="az">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Texniki iş | VapeArt Baku</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="Sayt hazırda texniki iş rejimindədir. Tezliklə geri qayıdacağıq.">
    <meta name="robots" content="noindex, nofollow">

    {{-- Retry After for Search Engines --}}
    <meta http-equiv="retry-after" content="3600">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="/storefront/images/favicon.ico" type="image/x-icon">

    {{-- Theme Color --}}
    <meta name="theme-color" content="#000000">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #1a365d 0%, #153e75 50%, #2a4365 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .maintenance-container {
            text-align: center;
            padding: 40px 20px;
            max-width: 550px;
        }

        .maintenance-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            position: relative;
        }

        .gear {
            position: absolute;
            animation: rotate 4s linear infinite;
        }

        .gear-large {
            width: 80px;
            height: 80px;
            top: 0;
            left: 0;
            color: #63b3ed;
        }

        .gear-small {
            width: 50px;
            height: 50px;
            bottom: 0;
            right: 0;
            color: #90cdf4;
            animation-direction: reverse;
            animation-duration: 3s;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .maintenance-title {
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #63b3ed 0%, #4299e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .maintenance-message {
            font-size: clamp(14px, 2.5vw, 16px);
            color: #a0aec0;
            margin-bottom: 40px;
            line-height: 1.7;
        }

        .progress-bar {
            width: 100%;
            max-width: 300px;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            margin: 0 auto 40px;
            overflow: hidden;
        }

        .progress-bar-inner {
            height: 100%;
            width: 60%;
            background: linear-gradient(90deg, #4299e1, #63b3ed, #4299e1);
            background-size: 200% 100%;
            border-radius: 3px;
            animation: progress 2s ease-in-out infinite;
        }

        @keyframes progress {
            0% { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }

        .contact-info {
            padding: 24px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-info h3 {
            font-size: 14px;
            font-weight: 500;
            color: #a0aec0;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contact-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .contact-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .contact-link:hover {
            color: #63b3ed;
        }

        .contact-link svg {
            width: 18px;
            height: 18px;
        }

        .social-links {
            margin-top: 30px;
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .social-link {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #4299e1;
            transform: translateY(-2px);
        }

        .social-link svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <svg class="gear gear-large" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <svg class="gear gear-small" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <h1 class="maintenance-title">Texniki iş gedir</h1>
        <p class="maintenance-message">
            Saytımız hazırda yeniləmə və təkmilləşdirmə işləri aparılır.
            Tezliklə sizinlə yenidən görüşəcəyik. Anlayışınız üçün təşəkkür edirik.
        </p>

        <div class="progress-bar">
            <div class="progress-bar-inner"></div>
        </div>

        <div class="contact-info">
            <h3>Bizimlə əlaqə</h3>
            <div class="contact-links">
                <a href="tel:+994501234567" class="contact-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    +994 50 123 45 67
                </a>
                <a href="mailto:info@vapeart.az" class="contact-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    info@vapeart.az
                </a>
            </div>

            <div class="social-links">
                <a href="https://instagram.com/vapeart.az" class="social-link" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="https://facebook.com/vapeart.az" class="social-link" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
