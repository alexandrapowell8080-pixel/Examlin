<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>Contact Us | Examlin</title>
    <meta content="Get in touch with Examlin for support, questions, or feedback regarding our exam preparation platform." name="description">
    
    <meta content="Contact Us | Examlin" property="og:title">
    <meta content="Get in touch with Examlin for support, questions, or feedback regarding our exam preparation platform." property="og:description">
    <meta content="{{ asset('images/logo.png') }}" property="og:image">
    <meta content="https://examlin.com/contact/" property="og:url">
    <meta content="website" property="og:type">
    <meta content="Examlin" property="og:site_name">
    
    <meta content="yes" name="mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="Examlin" name="apple-mobile-web-app-title">
    <link href="https://examlin.com/contact/" rel="canonical">

    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
    
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_V3_SITE_KEY') }}"></script>
</head>
<body class="bg-main font-inter">
    <div id="root">
        <div class="page-wrapper">
            
            @include('partials.header')

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-primary">Get In Touch</span>
                        <h1 class="section-title">Contact Us</h1>
                        <p class="section-desc">Have a question, need support, or want to provide feedback? Fill out the form below and our team will get back to you.</p>
                    </div>

                    <div class="feature-grid">
                        
                        <div class="feature-text-block">
                            <h2 class="feature-title" style="color: var(--text-dark); font-size: 28px;">We're here to help</h2>
                            <p class="feature-desc" style="color: var(--text-muted);">Our goal is to make your exam preparation as seamless as possible. If you encounter any issues or have suggestions for new exams, let us know.</p>
                            
                            <div style="margin-top: 32px;">
                                <div class="step-card" style="padding: 20px; margin-bottom: 16px;">
                                    <h4 style="font-size: 16px; font-weight: 700; color: var(--brand-dark); margin-bottom: 8px;">Email Support</h4>
                                    <p style="font-size: 14px; color: var(--text-muted);">For general inquiries, technical support, or partnership opportunities.</p>
                                    <a href="mailto:admin@examlin.com" class="text-primary" style="font-weight: 600; display: inline-block; margin-top: 8px;">admin@examlin.com</a>
                                </div>
                                
                                <div class="step-card" style="padding: 20px;">
                                    <h4 style="font-size: 16px; font-weight: 700; color: var(--brand-dark); margin-bottom: 8px;">Business Hours</h4>
                                    <p style="font-size: 14px; color: var(--text-muted);">Monday - Friday: 9:00 AM - 5:00 PM (EST)<br>Weekend support is limited.</p>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card" style="background-color: var(--bg-white);">
                            
                            @if(session('success'))
                                <div style="background-color: rgba(154, 74, 122, 0.1); border-left: 4px solid var(--primary-color); padding: 16px; margin-bottom: 24px; border-radius: 4px;">
                                    <p style="color: var(--primary-color); font-weight: 600; font-size: 14px;">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if($errors->any())
                                <div style="background-color: rgba(220, 53, 69, 0.1); border-left: 4px solid #dc3545; padding: 16px; margin-bottom: 24px; border-radius: 4px;">
                                    <ul style="color: #dc3545; font-size: 14px; margin: 0; padding-left: 16px;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="contact-form" action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                <div class="mb-md">
                                    <label for="name" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; text-transform: uppercase;">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background-color: var(--bg-main); color: var(--text-dark);">
                                </div>

                                <div class="mb-md">
                                    <label for="email" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; text-transform: uppercase;">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background-color: var(--bg-main); color: var(--text-dark);">
                                </div>

                                <div class="mb-md">
                                    <label for="subject" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; text-transform: uppercase;">Subject</label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background-color: var(--bg-main); color: var(--text-dark);">
                                </div>

                                <div class="mb-md">
                                    <label for="message" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; text-transform: uppercase;">Your Message</label>
                                    <textarea id="message" name="message" required rows="5" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background-color: var(--bg-main); color: var(--text-dark); resize: vertical;">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
                                    Send Message
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>
                                
                                <p style="font-size: 10px; color: var(--text-muted); text-align: center; margin-top: 16px;">
                                    This site is protected by reCAPTCHA and the Google 
                                    <a href="https://policies.google.com/privacy" target="_blank" style="color: var(--primary-color);">Privacy Policy</a> and 
                                    <a href="https://policies.google.com/terms" target="_blank" style="color: var(--primary-color);">Terms of Service</a> apply.
                                </p>
                            </form>
                        </div>
                    </div>

                </div>
            </section>

            @include('partials.footer')

        </div>
    </div>

    <script>
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env("RECAPTCHA_V3_SITE_KEY") }}', {action: 'contact_submit'}).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    form.submit();
                });
            });
        });
    </script>
</body>
</html>