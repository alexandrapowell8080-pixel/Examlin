@php
    $pageTitle = "{$examName->name} | {$exam->name} | {$category->name} | Examlin";
    $pageDesc = "Free {$category->name} {$exam->name} practice: {$examName->name}. {$questions->count()} questions with instant feedback and rationales.";
    $pageKeywords = "examlin, {$category->slug}, {$exam->slug}, {$examName->slug}, practice test";
    $canonical = route('quiz.show', [$category->slug, $exam->slug, $examName->slug]);
    
    $questionNumber = $questions->search(fn($q) => $q->id === $currentQuestion->id) + 1;
    
    $choices = $currentQuestion->choices;
    
    $selectedChoice = request()->query('choice');
    $isAnswered = $selectedChoice !== null || session()->has("quiz_answered_{$examName->id}_{$currentQuestion->id}");
    $isCorrect = $selectedChoice !== null && ($selectedChoice === $currentQuestion->correctAnswer);
    
    $progress = session()->get("quiz_progress_{$examName->id}", [
        'answered_count' => 0,
        'correct_count' => 0,
    ]);
    
    $answeredCount = $progress['answered_count'];
    $correctCount = $progress['correct_count'];
    
    $alreadyCounted = session()->has("quiz_answered_{$examName->id}_{$currentQuestion->id}");
    
    $shouldCountProgress = $selectedChoice !== null && !$alreadyCounted;
    
    if ($shouldCountProgress) {
        session()->put("quiz_answered_{$examName->id}_{$currentQuestion->id}", true);
        
        $answeredCount++;
        if ($isCorrect) {
            $correctCount++;
        }
        
        session()->put("quiz_progress_{$examName->id}", [
            'answered_count' => $answeredCount,
            'correct_count' => $correctCount,
        ]);
    }
    
    $highScoreKey = "quiz_highscore_{$examName->id}";
    $highScore = session()->get($highScoreKey, 87);
    
    $isLastQuestion = $questionNumber === $questions->count();
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
    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Quiz",
        "name": "{{ $examName->name }}",
        "description": "{{ $pageDesc }}",
        "hasPart": [
            @foreach($questions as $q)
            {
                "@@type": "Question",
                "name": "Question {{ $loop->iteration }}",
                "text": "{{ strip_tags($q->question) }}",
                "acceptedAnswer": {
                    "@@type": "Answer",
                    "text": "Option {{ $q->correctAnswer }}"
                }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
</head>
<body>
     @include('partials.header')
    
    
    <main class="question-page">
        <div class="container" id="quiz-container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a class="breadcrumb__link" href="/">Home</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                <span>{{ $category->classification->name ?? 'Exams' }}</span>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                <a class="breadcrumb__link" href="{{ route('exam.category', $category->slug) }}">{{ $category->name }}</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                <a class="breadcrumb__link" href="{{ route('exam.category', $category->slug) }}#{{ $exam->slug }}">{{ $exam->name }}</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                <span class="breadcrumb__current" aria-current="page">{{ $examName->name }}</span>
            </nav>

            <div class="question-page__header">
                <h1 class="question-page__title"> ®{{ $examName->name }}</h1>
                <p class="question-page__meta">{{ $questions->count() }} questions · Free Practice</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="grid lg:grid-cols-5 gap-6">
                        
                        <div class="lg:col-span-3">
                         
                                <div class="mb-6">

                                    <div style="width: 100%; height: 10px; background: #e6e6e2; border-radius: 9999px; overflow: hidden;">
                                        <div 
                                            id="progress-bar-fill"
                                            style="height: 100%; border-radius: 9999px; width: {{ ($questionNumber / $questions->count()) * 100 }}%; background: linear-gradient(90deg, var(--magenta) 0%, var(--magenta-light) 100%); transition: width 0.5s ease-out;"
                                        ></div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 12px;">
                                        <span style="font-weight: 500; color: var(--gray);">Question {{ $questionNumber }}</span>
                                        <span class="text-muted-foreground">of {{ $questions->count() }}</span>
                                    </div>
                                </div>
 
                            <div class="bg-card border border-border rounded-2xl p-6 md:p-8">
                                
                                
                                @if($currentQuestion->extract)
                                    <div class="question-extract mb-4 p-4 rounded-xl bg-offwhite border-l-4" style="border-left-color: var(--sage)">
                                        {{ $currentQuestion->extract }}
                                    </div>
                                @endif

                                <div style="display: none" class="question-extract_ mb-4 p-4 rounded-xl bg-offwhite border-l-4" style="border-left-color: var(--sage)">
                                    </div>
                                
                                <p class="text-lg md:text-xl font-semibold text-foreground leading-relaxed font-inter" id="question-text">{{ $currentQuestion->question }}</p>
                                
                                @if($currentQuestion->image)
                                    <div class="question-image mt-4 text-center">
                                        <img src="{{ asset('storage/' . $currentQuestion->image) }}" alt="Question illustration" loading="lazy" class="max-w-full h-auto rounded-xl">
                                    </div>
                                @endif
                                <div style="display:none" class="question-image mt-4 text-center">
                                        <img src="{{ asset('storage/' . $currentQuestion->image) }}" alt="Question illustration" loading="lazy" class="max-w-full h-auto rounded-xl">
                                    </div>

                                <div id="rationale-card" class="mt-6 rounded-xl p-4 flex gap-3 rationale-card" 
                                     style="background-color: rgba(154, 74, 122, 0.07); border: 1.5px solid rgba(154, 74, 122, 0.25); display: {{ $isAnswered ? 'flex' : 'none' }};">
                                    <div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center mt-0.5" style="background-color: rgba(154, 74, 122, 0.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lightbulb w-4 h-4" style="color: rgb(154, 74, 122);"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-widest font-inter mb-1" style="color: rgb(154, 74, 122);">Rationale</p>
                                        <p class="text-sm leading-relaxed text-foreground font-inter" id="rationale-text">
                                                                                 
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-2">
                            <div class="space-y-4">
                                
                                <div class="space-y-2" id="choices-list" 
                                     data-correct-answer="{{ $currentQuestion->correctAnswer }}"
                                     data-question-id="{{ $currentQuestion->id }}"
                                     data-already-counted="{{ $alreadyCounted ? 'true' : 'false' }}"
                                     data-exam-name-id="{{ $examName->id }}"
                                     data-answered-count="{{ $answeredCount }}"
                                     data-correct-count="{{ $correctCount }}">
                                    @foreach($choices as $choice)
                                        @php
                                            $isSelected = $isAnswered && ($selectedChoice === $choice['letter']);
                                            $isCorrectChoice = $choice['letter'] === $currentQuestion->correctAnswer;
                                            $showCorrectState = $isAnswered && $isCorrectChoice;
                                            $showIncorrectState = $isAnswered && $isSelected && !$isCorrectChoice;
                                        @endphp
                                        <button id="choice_card{{ $choice['letter'] }}" class="w-full text-left flex items-center gap-3 p-4 rounded-xl border transition-all duration-150 hover:scale-[1.01] hover:border-primary/30 choice-button {{ $showCorrectState ? 'choice-button--correct' : '' }} {{ $showIncorrectState ? 'choice-button--incorrect' : '' }}" 
                                                role="radio" 
                                                aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
                                                data-choice="{{ $choice['letter'] }}"
                                                {{ $isAnswered ? 'disabled' : '' }}
                                                onclick="selectAnswer(this)">
                                            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 text-xs font-bold font-inter choice__letter {{ $showCorrectState ? 'border-green-500 bg-green-500 text-white' : ($showIncorrectState ? 'border-red-400 bg-red-50 text-red-600' : 'border-border text-muted-foreground') }}">
                                                {{ $choice['letter'] }}
                                            </div>
                                            <span class="text-sm font-medium text-foreground " id="choice_text{{ $choice['letter'] }}">{{ $choice['text'] }}</span>
                                        </button>
                                    @endforeach
                                </div>

                                <div class="flex items-center justify-between pt-4">
                                    @if($previousId)
                                        <button type="button" class="btn-nav btn-outline" id="prev-btn" onclick="navigateQuestion('previous')" {{ !$previousId ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                                            Previous
                                        </button>
                                    @else
                                        <button disabled class="btn-nav btn-outline disabled">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                                            Previous
                                        </button>
                                    @endif

                                    @if($nextId)
                                        <button type="button" class="btn-nav btn-filled" id="next-btn" onclick="navigateQuestion('next')" {{ !$isAnswered ? 'disabled' : '' }}>
                                            Next
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                                        </button>
                                    @else
                                        <a href="{{ route('quiz.results', [$category->slug, $exam->slug, $examName->slug]) }}" 
                                           id="next-btn"
                                           class="btn-nav btn-filled {{ !$isAnswered ? 'opacity-50 pointer-events-none' : '' }}" 
                                           {{ !$isAnswered ? 'tabindex="-1"' : '' }}>
                                            Results
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="mt-4 text-center text-xs text-muted-foreground" id="progress-text">
                        <span id="total_answered">{{ $answeredCount }}</span> of {{ $questions->count() }} answered · {{ $correctCount }} correct
                    </div>
                    <!-- Highest Attempt Badge -->
<div class="mt-6">
    <div style="background: var(--offwhite); border: 1px solid #e6e6e2; border-radius: 0.75rem; padding: 1rem; text-align: center;">
        <p style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray); margin-bottom: 0.5rem; font-family: var(--font);">
            Highest Attempt
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
            <span style="font-size: 1.5rem; font-weight: 800; color: var(--magenta); font-family: var(--font); line-height: 1;" id="high-score-display">{{ $highScore }}%</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                <path d="m18 15-6-6-6 6"/>
            </svg>
        </div>
        <p style="font-size: 0.75rem; color: var(--gray); margin-top: 0.5rem; font-family: var(--font);">
            Keep practicing to improve!
        </p>
    </div>
</div>
                </div>
                
                <div class="hidden lg:block">
                    <div class="sticky top-24">
                        <div class="space-y-6">
                            
                            <div class="bg-card border border-border rounded-2xl p-4">
                                <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider font-inter mb-3">More {{ $exam->name }} Quizzes</h3>
                                <div class="space-y-1">
                                    @foreach($exam->examNames as $sidebarExamName)
                                    <a class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-150 {{ $sidebarExamName->id == $examName->id ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-accent hover:text-foreground' }}" 
                                       href="{{ route('quiz.show', [$category->slug, $exam->slug, $sidebarExamName->slug]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-3.5 h-3.5"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                                        {{ $sidebarExamName->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="bg-card border border-border rounded-2xl p-4">
                                <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider font-inter mb-3">Other {{ $category->name }} Sections</h3>
                                <div class="space-y-1">
                                    @foreach($category->exams->where('id', '!=', $exam->id) as $otherExam)
                                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-sm text-muted-foreground hover:bg-accent hover:text-foreground transition-all duration-150" 
                                       href="{{ route('exam.category', $category->slug) }}#{{ $otherExam->slug }}">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open w-3.5 h-3.5"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg>
                                            {{ $otherExam->name }}
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-3 h-3"><path d="m9 18 6-6-6-6"></path></svg>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="bg-card border border-border rounded-2xl p-4">
                                <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider font-inter mb-3">Related Exams</h3>
                                <div class="space-y-1">
                                    @foreach($relatedExams ?? [] as $related)
                                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-sm text-muted-foreground hover:bg-accent hover:text-foreground transition-all duration-150" 
                                       href="{{ route('exam.category', $related->slug) }}">
                                        <span>{{ $related->name }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-3 h-3"><path d="m9 18 6-6-6-6"></path></svg>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        let total_answered = 0;
        const toggleBtn = document.querySelector('.nav__mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        toggleBtn?.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.hidden = isExpanded;
        });

        const choicesList = document.getElementById('choices-list');
        const rationaleCard = document.getElementById('rationale-card');
        const nextBtn = document.getElementById('next-btn');
        const prevBtn = document.getElementById('prev-btn');
        const choiceButtons = document.querySelectorAll('.choice-button');
        
        const correctAnswer = choicesList?.dataset.correctAnswer;
        let questionId = choicesList?.dataset.questionId;
        const alreadyCounted = choicesList?.dataset.alreadyCounted === 'true';
        const examNameId = choicesList?.dataset.examNameId;
        const totalQuestions = {{ $questions->count() }};
        const isLastQuestion = {{ $isLastQuestion ? 'true' : 'false' }};
        const csrfToken = '{{ csrf_token() }}';
        
        let questionAnswered = {{ $isAnswered ? 'true' : 'false' }};
        let currentAnsweredCount = {{ $answeredCount }};
        let currentCorrectCount = {{ $correctCount }};
        
        function selectAnswer(btn) {
            if (questionAnswered) return;
            
            const selectedChoice = btn.dataset.choice;
            const isCorrect = (selectedChoice === correctAnswer);
            
            choiceButtons.forEach(b => {
                b.disabled = true;
                b.style.cursor = 'default';
                
                if (b.dataset.choice === correctAnswer) {
                    b.classList.add('choice-button--correct');
                    const letterEl = b.querySelector('.choice__letter');
                    if (letterEl) {
                        letterEl.classList.remove('border-border', 'text-muted-foreground');
                        letterEl.classList.add('border-green-500', 'bg-green-500', 'text-white');
                    }
                }
                
                if (b.dataset.choice === selectedChoice && !isCorrect) {
                    b.classList.add('choice-button--incorrect');
                    const letterEl = b.querySelector('.choice__letter');
                    if (letterEl) {
                        letterEl.classList.remove('border-border', 'text-muted-foreground');
                        letterEl.classList.add('border-red-400', 'bg-red-50', 'text-red-600');
                    }
                }
            });
            
            if (rationaleCard) {
                rationaleCard.style.display = 'flex';
                if (window.innerWidth < 1024) {
                    rationaleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            if (nextBtn) {
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-50', 'pointer-events-none');
                if (nextBtn.tagName === 'A') {
                    nextBtn.removeAttribute('tabindex');
                }
            }
            
            if (!alreadyCounted) {
                currentAnsweredCount++;
                if (isCorrect) {
                    currentCorrectCount++;
                }
                
                const progressEl = document.getElementById('progress-text');
                if (progressEl) {
                    progressEl.textContent = `${currentAnsweredCount} of ${totalQuestions} answered · ${currentCorrectCount} correct`;
                }
                
                fetch('/quiz/update-progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        exam_name_id: examNameId,
                        question_id: questionId,
                        is_correct: isCorrect,
                        answered_count: currentAnsweredCount,
                        correct_count: currentCorrectCount
                    })
                }).catch(err => console.error('Progress update failed:', err));
            }
            
            questionAnswered = true;
            
            if (isLastQuestion && nextBtn && nextBtn.tagName === 'A') {
                nextBtn.style.fontWeight = '800';
                nextBtn.style.textDecoration = 'underline';
            }
        }
        
        async function navigateQuestion(direction) {
            if (direction === 'next' && !questionAnswered) {
                return;
            }
            
            const btn = direction === 'next' ? nextBtn : prevBtn;
            if (!btn) return;
            
            const originalContent = btn.innerHTML;
            btn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...`;
            btn.disabled = true;
            
            try {
                const formData = new FormData();
                formData.append('exam_name_id', examNameId);
                formData.append('direction', direction);
                formData.append('_token', csrfToken);
                
                const response = await fetch('{{ route("quiz.navigate") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });
                
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.querySelector('#quiz-container');
                
                if (newContainer) {
                    document.getElementById('quiz-container').innerHTML = newContainer.innerHTML;
                    window.history.pushState({}, '', response.url);
                    
                    const newChoicesList = document.getElementById('choices-list');
                    if (newChoicesList) {
                        questionAnswered = newChoicesList.dataset.alreadyCounted === 'true';
                        currentAnsweredCount = parseInt(newChoicesList.dataset.answeredCount) || 0;
                        currentCorrectCount = parseInt(newChoicesList.dataset.correctCount) || 0;
                    }
                    
                    initQuizEvents();
                    
                    const header = document.querySelector('.question-page__header');
                    if (header) {
                        header.scrollIntoView({ behavior: 'smooth' });
                    }
                } else {
                    window.location.href = response.url;
                }
            } catch (error) {
                console.error('Navigation error:', error);
                window.location.reload();
            }
        }
        
        function initQuizEvents() {
            const newChoicesList = document.getElementById('choices-list');
            const newRationaleCard = document.getElementById('rationale-card');
            const newNextBtn = document.getElementById('next-btn');
            const newPrevBtn = document.getElementById('prev-btn');
            const newChoiceButtons = document.querySelectorAll('.choice-button');
            
            if (newChoicesList) {
                window.selectAnswer = function(btn) {
                    if (questionAnswered) return;
                    
                    const correctAnswer = newChoicesList.dataset.correctAnswer;
                    const selectedChoice = btn.dataset.choice;
                    const isCorrect = (selectedChoice === correctAnswer);
                    
                    newChoiceButtons.forEach(b => {
                        b.disabled = true;
                        b.style.cursor = 'default';
                        
                        if (b.dataset.choice === correctAnswer) {
                            b.classList.add('choice-button--correct');
                            const letterEl = b.querySelector('.choice__letter');
                            if (letterEl) {
                                letterEl.classList.remove('border-border', 'text-muted-foreground');
                                letterEl.classList.add('border-green-500', 'bg-green-500', 'text-white');
                            }
                        }
                        
                        if (b.dataset.choice === selectedChoice && !isCorrect) {
                            b.classList.add('choice-button--incorrect');
                            const letterEl = b.querySelector('.choice__letter');
                            if (letterEl) {
                                letterEl.classList.remove('border-border', 'text-muted-foreground');
                                letterEl.classList.add('border-red-400', 'bg-red-50', 'text-red-600');
                            }
                        }
                    });
                    
                    if (newRationaleCard) {
                        newRationaleCard.style.display = 'flex';
                        if (window.innerWidth < 1024) {
                            newRationaleCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                    
                    if (newNextBtn) {
                        newNextBtn.disabled = false;
                        newNextBtn.classList.remove('opacity-50', 'pointer-events-none');
                        if (newNextBtn.tagName === 'A') {
                            newNextBtn.removeAttribute('tabindex');
                        }
                    }
                    
                    const alreadyCounted = newChoicesList.dataset.alreadyCounted === 'true';
                    if (!alreadyCounted) {
                        currentAnsweredCount++;
                        if (isCorrect) {
                            currentCorrectCount++;
                        }
                        
                        const progressEl = document.getElementById('progress-text');
                        if (progressEl) {
                            progressEl.textContent = `${currentAnsweredCount} of ${totalQuestions} answered · ${currentCorrectCount} correct`;
                        }
                        
                        const examNameId = newChoicesList.dataset.examNameId;
                        let questionId = newChoicesList.dataset.questionId;
                        
                        fetch('/quiz/update-progress', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                exam_name_id: examNameId,
                                question_id: questionId,
                                is_correct: isCorrect,
                                answered_count: currentAnsweredCount,
                                correct_count: currentCorrectCount
                            })
                        }).catch(err => console.error('Progress update failed:', err));
                    }
                    
                    questionAnswered = true;
                };
            }
            
            if (newNextBtn) {
                newNextBtn.onclick = function() { nextQuestion('next'); };
            }
            if (newPrevBtn) {
                newPrevBtn.onclick = function() { navigateQuestion('previous'); };
            }
            
            const progressBar = document.getElementById('progress-bar-fill');
            if (progressBar) {
                const questionNumberMatch = document.querySelector('[style*="var(--gray)"]')?.textContent.match(/Question (\d+)/);
                const currNum = questionNumberMatch ? parseInt(questionNumberMatch[1]) : 1;
                const percentage = totalQuestions > 0 ? Math.min(100, (currNum / totalQuestions) * 100) : 0;
                progressBar.style.width = percentage + '%';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            initQuizEvents();
            
            if (nextBtn && !questionAnswered) {
                nextBtn.disabled = true;
                if (nextBtn.tagName === 'A') {
                    nextBtn.classList.add('opacity-50', 'pointer-events-none');
                    nextBtn.setAttribute('tabindex', '-1');
                }
            }
            
            const progressBar = document.getElementById('progress-bar-fill');
            if (progressBar) {
                const percentage = totalQuestions > 0 ? Math.min(100, ({{ $questionNumber }} / totalQuestions) * 100) : 0;
                progressBar.style.width = percentage + '%';
            }
        });
        
        window.addEventListener('popstate', function() {
            window.location.reload();
        });

        function nextQuestion(){
            console.log(examNameId)
            console.log(questionId)
             fetch('/question-next', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                exam_name_id: examNameId,
                                question_id: questionId,
                            })
                        })
                        .then(res => res.json())
                        .then(res=>{

                            choiceButtons.forEach(b => {
                                b.disabled = false;
                                b.style.cursor = 'pointer';
                                
                                let letters = ['A','B','C','D','E','F','G']

                                letters.forEach(element => {

                                    let id = 'choice_card'+element
                                    let btn = document.getElementById(id)
                                    btn?.disabled = false;
                                    console.log(btn)
                                    btn?.classList.remove('choice-button--correct','choice-button--incorrect','text-muted-background','border-green-500', 'bg-green-500', 'text-white','border-red-400', 'bg-red-50', 'text-red-600');
                                    btn?.classList.add('text-muted-foreground','border-border', 'text-muted-foreground');
                                     btn?.setAttribute('aria-pressed', 'false');
                                });

                            });


                            total_answered ++;
                            document.getElementById('question-text').innerText = res.question.question
                            document.getElementById('choice_textA').innerText = res.question.choiceA
                            document.getElementById('choice_textB').innerText = res.question.choiceB
                            document.getElementById('choice_textC').innerText = res.question.choiceC
                            document.getElementById('choice_textD').innerText = res.question.choiceD
                            document.getElementById('total_answered').innerText = total_answered
                            
                          
                            questionId = res.question.id
                        })
                        .catch(err => console.error('Progress update failed:', err));
        }
    </script>
</body>
</html>