@php
    $examName = $exam->title ?? 'Practice Tests';
    $examSlug = $exam->slug ?? 'exam';
    $meta = [
        'title' => "{$examName} | Examlin",
        'meta_description' => "Prepare for {$examName} with free practice tests. Instant feedback, detailed rationales, and progress tracking.",
        'keywords' => "examlin, {$examSlug} practice, exam prep, free tests",
        'canonical' => route('exam.category', $examSlug),
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['meta_description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <link rel="canonical" href="{{ $meta['canonical'] }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Shared Header -->
    <header class="header">
        <div class="container header__inner">
            <a href="/" class="logo">Exam<span>lin</span></a>
            <nav class="nav__desktop">
                @foreach($navExams as $navExam)
                    <a href="{{ route('exam.category', $navExam->slug) }}">{{ $navExam->title }}</a>
                @endforeach
            </nav>
            <button class="nav__mobile-toggle" aria-label="Toggle navigation" onclick="document.getElementById('mobile-menu').classList.toggle('active')">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <nav id="mobile-menu" class="nav__mobile-menu">
            @foreach($navExams as $navExam)
                <a href="{{ route('exam.category', $navExam->slug) }}">{{ $navExam->title }}</a>
            @endforeach
        </nav>
    </header>

    <main>
        <section class="exam-header">
            <div class="container">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a class="breadcrumb__link" href="/">Home</a>
                    <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                    <span class="breadcrumb__current">{{ $exam->title }}</span>
                </nav>

                <div class="exam-header__brand">
                    <a class="exam-header__logo" href="/">
                        <span>E</span>
                    </a>
                    <span class="exam-header__name">Examlin</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--sage);width:1rem;height:1rem"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    <span class="exam-header__badge">{{ $exam->category_label ?? 'Practice Exams' }}</span>
                    <h1 class="exam-header__title">{{ $exam->title }}</h1>
                </div>

                <p class="exam-header__desc">{{ $exam->description ?? "Prepare for {$exam->title} with practice questions covering all key sections." }}</p>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <h2 style="font-size:1.125rem;font-weight:700;font-family:var(--font);margin-bottom:1.5rem;color:var(--nearblack)">Subjects</h2>
                
                <div class="subjects-grid">
                    @foreach($subjects as $subject)
                    <article class="subject-card">
                        <div class="subject-card__header">
                            <div class="subject-card__icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                            </div>
                            <h3 class="subject-card__title">{{ $subject->name }}</h3>
                        </div>
                        <div class="test-list">
                            @foreach($subject->tests as $index => $test)
                            <a class="test-link {{ $test->is_active ?? true ? '' : 'test-link--active' }}" 
                               href="{{ route('quiz.show', [$exam->slug, $subject->slug, $test->slug]) }}">
                                <div class="test-link__left">
                                    <span class="test-link__num">{{ $index + 1 }}</span>
                                    <div class="test-link__info">
                                        <span class="test-link__title">{{ $test->title }}</span>
                                        <div class="test-link__meta">
                                            <span class="test-link__badge">Free Practice</span>
                                            <span class="test-link__count">{{ $test->question_count }} Questions</span>
                                        </div>
                                    </div>
                                </div>
                                <svg class="test-link__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                            @endforeach
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            © {{ date('Y') }} Examlin. All rights reserved. | <a href="/privacy">Privacy Policy</a>
        </div>
    </footer>

    <script>
        document.querySelector('.nav__mobile-toggle')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('active');
        });
    </script>
</body>
</html>