@php
    $categoryName = $category->name ?? 'Practice Tests';
    $categorySlug = $category->slug ?? 'exam';
    $classificationName = $category->classification->name ?? 'Exams';
    
    $meta = [
        'title' => "{$categoryName} Practice Tests | Examlin",
        'meta_description' => "Prepare for {$categoryName} with free practice tests. Instant feedback, detailed rationales, and progress tracking.",
        'keywords' => "examlin, {$categorySlug} practice, {$categorySlug} prep, free tests, {$classificationName}",
        'canonical' => route('exam.category', $categorySlug),
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
    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebPage",
        "name": "{{ $meta['title'] }}",
        "description": "{{ $meta['meta_description'] }}",
        "publisher": {
            "@@type": "Organization",
            "name": "Examlin",
            "url": "https://examlin.com"
        },
        "breadcrumb": {
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://examlin.com"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "{{ $classificationName }}",
                    "item": "https://examlin.com/{{ $categorySlug }}"
                }
            ]
        }
    }
    </script>
</head>
<body>
     @include('partials.header')

    <main>
        <section class="exam-header">
            <div class="container">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a class="breadcrumb__link" href="/">Home</a>
                    <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    <span>{{ $classificationName }}</span>
                    <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    <span class="breadcrumb__current" aria-current="page">{{ $categoryName }}</span>
                </nav>

                <div class="exam-header__brand">
                    <a class="exam-header__logo" href="/" aria-label="Examlin Home">
                        <span>E</span>
                    </a>
                    <span class="exam-header__name">Examlin</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--sage);width:1rem;height:1rem" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    <span class="exam-header__badge">{{ $classificationName }}</span>
                    <h1 class="exam-header__title">{{ $categoryName }}</h1>
                </div>

                <p class="exam-header__desc">Prepare for {{ $categoryName }} with practice questions covering all key sections. Free, instant feedback, and detailed rationales.</p>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 style="font-size:1.125rem;font-weight:700;font-family:var(--font);margin-bottom:1.5rem;color:var(--nearblack)">Sections</h2>
                
                <div class="subjects-grid">
                    @forelse($category->exams as $exam)
                    <article class="subject-card" id="{{ $exam->slug }}">
                        <div class="subject-card__header">
                            <div class="subject-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                            </div>
                            <h3 class="subject-card__title">{{ $exam->name }}</h3>
                        </div>
                        <div class="test-list">
                            @forelse($exam->examNames as $index => $examName)
                            <a class="test-link" 
                               href="{{ route('quiz.show', [$category->slug, $exam->slug, $examName->slug]) }}"
                               aria-label="Start {{ $examName->name }} for {{ $exam->name }}">
                                <div class="test-link__left">
                                    <span class="test-link__num">{{ $index + 1 }}</span>
                                    <div class="test-link__info">
                                        <span class="test-link__title">{{ $examName->name }}</span>
                                        <div class="test-link__meta">
                                            <span class="test-link__badge">Free Practice</span>
                                            <span class="test-link__count">{{ $examName->questions()->count() }} Questions</span>
                                        </div>
                                    </div>
                                </div>
                                <svg class="test-link__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                            @empty
                            <p style="color:var(--gray);font-size:0.875rem">No practice tests available yet.</p>
                            @endforelse
                        </div>
                    </article>
                    @empty
                    <p style="color:var(--gray);grid-column:1/-1">No sections available for {{ $categoryName }} yet. Check back soon!</p>
                    @endforelse
                </div>
            </div>
        </section>

        @if(isset($relatedExams) && $relatedExams->isNotEmpty())
        <section class="section" style="background:#f8fafc">
            <div class="container">
                <h2 style="font-size:1.125rem;font-weight:700;font-family:var(--font);margin-bottom:1.5rem;color:var(--nearblack)">You Might Also Like</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem">
                    @foreach($relatedExams as $related)
                    <a href="{{ route('exam.category', $related->slug) }}" 
                       class="related-card"
                       style="display:block;padding:1rem;border:1px solid var(--lightgray);border-radius:0.5rem;text-decoration:none;color:inherit;background:#fff;transition:transform 0.2s">
                        <div style="font-weight:600;margin-bottom:0.25rem">{{ $related->name }}</div>
                        <div style="font-size:0.875rem;color:var(--gray)">{{ $related->classification->name ?? 'Exam' }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>
@include('partials.footer')

    <script>
        const toggleBtn = document.querySelector('.nav__mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        toggleBtn?.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.hidden = isExpanded;
        });

        mobileMenu?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.hidden = true;
                toggleBtn?.setAttribute('aria-expanded', 'false');
            });
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>