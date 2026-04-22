@php
    $pageTitle = "{$test->title} | {$subject->name} | {$exam->title} | Examlin";
    $pageDesc = "Free {$exam->title} {$subject->name} practice: {$test->title}. {$questions->count()} questions with instant feedback and rationales.";
    $pageKeywords = "examlin, {$exam->slug}, {$subject->slug}, {$test->slug}, practice test";
    $canonical = route('quiz.show', [$exam->slug, $subject->slug, $test->slug]);
    
    $choices = $currentQuestion->choices;
    if (is_string($choices)) {
        $choices = json_decode($choices, true) ?? [];
    }
    if (!is_array($choices)) {
        $choices = [];
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
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

    <!-- Timer -->
    <div class="exam-timer" id="exam-timer">{{ gmdate('i:s', $test->duration_minutes * 60) }}</div>

    <main class="question-page">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a class="breadcrumb__link" href="/">Home</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <span>{{ $exam->category_label ?? 'Exams' }}</span>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <a class="breadcrumb__link" href="{{ route('exam.category', $exam->slug) }}">{{ $exam->title }}</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <span>{{ $subject->name }}</span>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <span class="breadcrumb__current">{{ $test->title }}</span>
            </nav>

            <!-- Page Header -->
            <div class="question-page__header">
                <h1 class="question-page__title">{{ $exam->title }} {{ $subject->name }} {{ $test->title }}</h1>
                <p class="question-page__meta">{{ $questions->count() }} questions · {{ $test->is_free ? 'Free Practice' : 'Premium' }}</p>
            </div>

            <div class="question-page__grid">
              
                <div>
                    <div class="question-card">
                        <div class="question-card__header">
                            <span class="question-card__badge">Question {{ $currentQuestion->order }}</span>
                            <span class="question-card__counter">of {{ $questions->count() }}</span>
                        </div>
                        <h2 class="question-card__text">{{ $currentQuestion->question_text ?? 'Question content unavailable' }}</h2>
                        
                        <!-- Choices -->
                        <div class="choices-list" role="radiogroup" aria-label="Answer choices" id="choices-list">
                            @foreach($choices as $choice)
                            <button class="choice-button" role="radio" aria-pressed="false" data-choice="{{ $choice['letter'] ?? '' }}">
                                <span class="choice__letter">{{ $choice['letter'] ?? '' }}</span>
                                <span class="choice__text">{{ $choice['text'] ?? '' }}</span>
                            </button>
                            @endforeach
                        </div>

                        <!-- Navigation -->
                        <div class="question-nav">
                            @if(isset($previousOrder))
                                <a class="nav-button" href="{{ route('quiz.show', [$exam->slug, $subject->slug, $test->slug]) }}?q={{ $previousOrder }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-right:0.25rem"><path d="m15 18-6-6 6-6"/></svg>
                                    Previous
                                </a>
                            @else
                                <button class="nav-button" disabled>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-right:0.25rem"><path d="m15 18-6-6 6-6"/></svg>
                                    Previous
                                </button>
                            @endif

                            @if(!$showRationale)
                                <button class="nav-button" id="next-btn">
                                    Next
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-left:0.25rem"><path d="m9 18 6-6-6-6"/></svg>
                                </button>
                            @else
                                @if(isset($nextOrder))
                                    <a class="nav-button" href="{{ route('quiz.show', [$exam->slug, $subject->slug, $test->slug]) }}?q={{ $nextOrder }}">
                                        Next Question
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-left:0.25rem"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                @else
                                    <a class="nav-button" href="{{ url('/quiz/results/' . $exam->slug . '/' . $subject->slug . '/' . $test->slug) }}" style="color:var(--magenta);font-weight:600">
                                        View Results
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-left:0.25rem"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Rationale -->
                    @if($showRationale)
                    <div class="rationale-card is-visible" id="rationale-card">
                        @if($currentQuestion->rationale_heading)
                            <h3 class="rationale-card__heading">{{ $currentQuestion->rationale_heading }}</h3>
                        @endif
                        @if($currentQuestion->rationale_content)
                            <p class="rationale-card__content">{{ $currentQuestion->rationale_content }}</p>
                        @endif
                    </div>
                    @endif

                    <!-- Question Indicators -->
                    <div class="question-indicators">
                        @foreach($questions as $q)
                        <a class="question-indicator {{ $q->order == ($currentQuestion->order ?? 1) ? 'question-indicator--active' : '' }}" 
                           href="{{ route('quiz.show', [$exam->slug, $subject->slug, $test->slug]) }}?q={{ $q->order }}">
                            {{ $q->order }}
                        </a>
                        @endforeach
                    </div>
                    <div class="question-progress">{{ $answeredCount ?? 0 }} of {{ $questions->count() }} answered · {{ $correctCount ?? 0 }} correct</div>
                </div>
                <aside class="sidebar">
                    <div class="sidebar__section">
                        <h3 class="sidebar__title">More {{ $subject->name }} Quizzes</h3>
                        <div class="sidebar__list">
                            @foreach($subject->tests as $sidebarTest)
                            <a class="sidebar__link {{ $sidebarTest->id == ($test->id ?? null) ? 'sidebar__link--active' : '' }}" 
                               href="{{ route('quiz.show', [$exam->slug, $subject->slug, $sidebarTest->slug]) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:0.875rem;height:0.875rem"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                                {{ $sidebarTest->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar__section">
                        <h3 class="sidebar__title">Other {{ $exam->title }} Subjects</h3>
                        <div class="sidebar__list">
                            @foreach($exam->subjects->where('id', '!=', ($subject->id ?? null)) as $otherSubject)
                            <a class="sidebar__link sidebar__link--with-chevron" href="{{ route('exam.category', $exam->slug) }}">
                                <span style="display:flex;align-items:center;gap:0.5rem">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:0.875rem;height:0.875rem"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                                    {{ $otherSubject->name }}
                                </span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:0.75rem;height:0.75rem"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar__section">
                        <h3 class="sidebar__title">Related Exams</h3>
                        <div class="sidebar__list">
                            @foreach($relatedExams ?? [] as $related)
                            <a class="sidebar__link sidebar__link--with-chevron" href="{{ route('exam.category', $related->slug) }}">
                                <span>{{ $related->title }}</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:0.75rem;height:0.75rem"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
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

        document.querySelectorAll('.choice-button').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.choice-button').forEach(b => b.setAttribute('aria-pressed', 'false'));
                this.setAttribute('aria-pressed', 'true');
            });
        });
n
        document.getElementById('next-btn')?.addEventListener('click', function() {
            const selected = document.querySelector('.choice-button[aria-pressed="true"]');
            if (selected) {
                document.getElementById('choices-list').style.display = 'none';
                const rationaleCard = document.getElementById('rationale-card');
                if (rationaleCard) rationaleCard.classList.add('is-visible');
                this.innerHTML = 'Next Question <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1rem;height:1rem;margin-left:0.25rem"><path d="m9 18 6-6-6-6"/></svg>';
                this.onclick = null;
            }
        });

        // Timer
        (function startTimer() {
            let timeLeft = {{ $test->duration_minutes * 60 }};
            const timerEl = document.getElementById('exam-timer');
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    timerEl.textContent = '00:00';
                    timerEl.style.background = '#dc2626';
                    return;
                }
                const mins = Math.floor(timeLeft / 60);
                const secs = timeLeft % 60;
                timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                timeLeft--;
            }, 1000);
        })();
    </script>
</body>
</html>