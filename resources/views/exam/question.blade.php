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
    
    $shouldCountProgress = $selectedChoice !== null && !session()->has("quiz_answered_{$examName->id}_{$currentQuestion->id}");
    
    if ($shouldCountProgress) {
        session()->put("quiz_answered_{$examName->id}_{$currentQuestion->id}", true);
        
        $answeredCount = ($answeredCount ?? 0) + 1;
        if ($isCorrect) {
            $correctCount = ($correctCount ?? 0) + 1;
        }
        session()->put("quiz_progress_{$examName->id}", [
            'answered_count' => $answeredCount,
            'correct_count' => $correctCount,
        ]);
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
    
    <div class="exam-timer" id="exam-timer" aria-live="polite">45:00</div>

    <main class="question-page">
        <div class="container">
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
                <h1 class="question-page__title">{{ $category->name }} {{ $exam->name }} {{ $examName->name }}</h1>
                <p class="question-page__meta">{{ $questions->count() }} questions · Free Practice</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="grid lg:grid-cols-5 gap-6">
                        
                        <div class="lg:col-span-3">
                            <div class="bg-card border border-border rounded-2xl p-6 md:p-8">
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="text-xs font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md font-inter">Question {{ $questionNumber }}</span>
                                    <span class="text-xs text-muted-foreground">of {{ $questions->count() }}</span>
                                </div>
                                
                                @if($currentQuestion->extract)
                                    <div class="question-extract mb-4 p-4 rounded-xl bg-offwhite border-l-4" style="border-left-color: var(--sage)">
                                        {{ $currentQuestion->extract }}
                                    </div>
                                @endif
                                
                                <p class="text-lg md:text-xl font-semibold text-foreground leading-relaxed font-inter">{{ $currentQuestion->question }}</p>
                                
                                @if($currentQuestion->image)
                                    <div class="question-image mt-4 text-center">
                                        <img src="{{ asset('storage/' . $currentQuestion->image) }}" alt="Question illustration" loading="lazy" class="max-w-full h-auto rounded-xl">
                                    </div>
                                @endif

                                <div id="rationale-card" class="mt-6 rounded-xl p-4 flex gap-3 rationale-card" 
                                     style="background-color: rgba(154, 74, 122, 0.07); border: 1.5px solid rgba(154, 74, 122, 0.25); display: {{ $isAnswered ? 'flex' : 'none' }};">
                                    <div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center mt-0.5" style="background-color: rgba(154, 74, 122, 0.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lightbulb w-4 h-4" style="color: rgb(154, 74, 122);"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-widest font-inter mb-1" style="color: rgb(154, 74, 122);">Rationale</p>
                                        <p class="text-sm leading-relaxed text-foreground font-inter" id="rationale-text">
                                            @if($currentQuestion->rationale)
                                                {{ $currentQuestion->rationale }}
                                            @else
                                                The correct answer is {{ $currentQuestion->correctAnswer }}. Review the explanation to understand the concept.
                                            @endif
                                        </p>
                                        @if($currentQuestion->resource_url)
                                            <p class="mt-2 text-xs text-muted-foreground">
                                                Source: <a href="{{ $currentQuestion->resource_url }}" target="_blank" rel="noopener" style="color: var(--sage)">{{ parse_url($currentQuestion->resource_url, PHP_URL_HOST) }}</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-2">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    @if($previousId)
                                        <form method="POST" action="{{ route('quiz.navigate') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="exam_name_id" value="{{ $examName->id }}">
                                            <input type="hidden" name="direction" value="previous">
                                            <button type="submit" class="flex items-center gap-1 text-sm font-medium text-muted-foreground hover:text-foreground disabled:opacity-30 disabled:cursor-not-allowed transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-4 h-4"><path d="m15 18-6-6 6-6"></path></svg>
                                                Previous
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="flex items-center gap-1 text-sm font-medium text-muted-foreground hover:text-foreground disabled:opacity-30 disabled:cursor-not-allowed transition-colors duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-4 h-4"><path d="m15 18-6-6 6-6"></path></svg>
                                            Previous
                                        </button>
                                    @endif

                                    @if($nextId)
                                        <form method="POST" action="{{ route('quiz.navigate') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="exam_name_id" value="{{ $examName->id }}">
                                            <input type="hidden" name="direction" value="next">
                                            <button type="submit" id="next-btn" class="flex items-center gap-1 text-sm font-medium text-muted-foreground hover:text-foreground disabled:opacity-30 disabled:cursor-not-allowed transition-colors duration-150">
                                                Next
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4"><path d="m9 18 6-6-6-6"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('quiz.results', [$category->slug, $exam->slug, $examName->slug]) }}" 
                                           id="next-btn"
                                           class="flex items-center gap-1 text-sm font-medium" style="color: var(--magenta); font-weight: 600">
                                            Results
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4"><path d="m9 18 6-6-6-6"></path></svg>
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="space-y-2" id="choices-list" 
                                     data-correct-answer="{{ $currentQuestion->correctAnswer }}"
                                     data-question-id="{{ $currentQuestion->id }}"
                                     data-already-counted="{{ session()->has("quiz_answered_{$examName->id}_{$currentQuestion->id}") ? 'true' : 'false' }}">
                                    @foreach($choices as $choice)
                                        @php
                                            $isSelected = $isAnswered && ($selectedChoice === $choice['letter']);
                                            $isCorrectChoice = $choice['letter'] === $currentQuestion->correctAnswer;
                                            $showCorrectState = $isAnswered && $isCorrectChoice;
                                            $showIncorrectState = $isAnswered && $isSelected && !$isCorrectChoice;
                                        @endphp
                                        <button class="w-full text-left flex items-center gap-3 p-4 rounded-xl border transition-all duration-150 hover:scale-[1.01] hover:border-primary/30 choice-button {{ $showCorrectState ? 'choice-button--correct' : '' }} {{ $showIncorrectState ? 'choice-button--incorrect' : '' }}" 
                                                role="radio" 
                                                aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
                                                data-choice="{{ $choice['letter'] }}"
                                                {{ $isAnswered ? 'disabled' : '' }}>
                                            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 text-xs font-bold font-inter choice__letter {{ $showCorrectState ? 'border-green-500 bg-green-500 text-white' : ($showIncorrectState ? 'border-red-400 bg-red-50 text-red-600' : 'border-border text-muted-foreground') }}">
                                                {{ $choice['letter'] }}
                                            </div>
                                            <span class="text-sm font-medium text-foreground">{{ $choice['text'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center gap-2 mt-6 flex-wrap">
                        @foreach($questions as $q)
                            @php
                                $qNumber = $questions->search(fn($item) => $item->id === $q->id) + 1;
                                $isCurrent = $q->id == $currentQuestion->id;
                                $isAnsweredQuestion = session()->has("quiz_answered_{$examName->id}_{$q->id}");
                            @endphp
                            <form method="POST" action="{{ route('quiz.navigate') }}" class="inline">
                                @csrf
                                <input type="hidden" name="exam_name_id" value="{{ $examName->id }}">
                                <input type="hidden" name="question_id" value="{{ $q->id }}">
                                <input type="hidden" name="direction" value="jump">
                                <button type="submit"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold font-inter transition-all duration-150 {{ $isCurrent ? 'bg-primary text-primary-foreground' : ($isAnsweredQuestion ? 'bg-sage text-white' : 'bg-accent text-muted-foreground border border-border') }}"
                                       aria-label="Question {{ $qNumber }}{{ $isAnsweredQuestion ? ' (answered)' : '' }}">
                                    {{ $qNumber }}
                                    @if($isAnsweredQuestion)
                                        <span class="sr-only">- answered</span>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 text-center text-xs text-muted-foreground" id="progress-text">
                        {{ $answeredCount ?? 0 }} of {{ $questions->count() }} answered · {{ $correctCount ?? 0 }} correct
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
        const choiceButtons = document.querySelectorAll('.choice-button');
        
        const correctAnswer = choicesList?.dataset.correctAnswer;
        const questionId = choicesList?.dataset.questionId;
        const alreadyCounted = choicesList?.dataset.alreadyCounted === 'true';
        
        choiceButtons.forEach(btn => {
            if (btn.disabled && !btn.classList.contains('choice-button--correct') && !btn.classList.contains('choice-button--incorrect')) {
                return;
            }
            
            btn.addEventListener('click', function() {
                const selectedChoice = this.dataset.choice;
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
                
                if (!alreadyCounted) {
                    const progressEl = document.getElementById('progress-text');
                    if (progressEl) {
                        const match = progressEl.textContent.match(/(\d+) of (\d+) answered · (\d+) correct/);
                        if (match) {
                            let [, answered, total, correct] = match;
                            answered = parseInt(answered) + 1;
                            if (isCorrect) {
                                correct = parseInt(correct) + 1;
                            }
                            progressEl.textContent = `${answered} of ${total} answered · ${correct} correct`;
                        }
                    }
                    
                    const currentIndicator = document.querySelector(`button[value="${questionId}"]`);
                    if (currentIndicator) {
                        currentIndicator.classList.remove('bg-accent', 'text-muted-foreground', 'border-border');
                        currentIndicator.classList.add('bg-sage', 'text-white');
                        currentIndicator.setAttribute('aria-label', currentIndicator.getAttribute('aria-label') + ' (answered)');
                    }
                    
                    if (nextBtn && nextBtn.textContent.trim() === 'Next') {
                        nextBtn.innerHTML = nextBtn.innerHTML.replace('Next', 'Next Question');
                    }
                }
            });
        });
        
        (function startTimer() {
            let timeLeft = 45 * 60; 
            const timerEl = document.getElementById('exam-timer');
            if (!timerEl) return;
            
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