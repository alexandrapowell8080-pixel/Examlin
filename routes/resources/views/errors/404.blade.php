<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png">
    <title>Page Not Found - 404</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
</head>
<body>
    @include('partials.header') 
    <section class="hero-section" style="min-height: 100vh;">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content center">
            <div class="hero-text-block" style="align-items: center; max-width: 600px; margin: 0 auto; padding: 0 20px;">
                <div class="hero-badge">
                    <span class="section-badge badge-primary" style="margin-bottom: 0;">Error 404</span>
                    <span>Lost in Space</span>
                </div>
                <h1 class="hero-title" style="font-size: 72px; color: var(--primary-color);">404</h1>
                <h2 class="hero-title">Oops! Page Not Found</h2>
                <p class="hero-subtitle">
                    The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
                </p>
                <p class="hero-desc">
                    Please check the URL configuration or use the buttons below to navigate back to safety.
                </p>
                <div class="hero-actions" style="justify-content: center;">
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        Go to Homepage
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-light">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
</body>
</html>
