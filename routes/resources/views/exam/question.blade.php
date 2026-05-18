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
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png">
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
                                
                                <p class="text-lg md:text-xl font-semibold text-foreground leading-relaxed font-inter" id="question-text">{{ $currentQuestion->question }}</p>
                                
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
                                                {!! $currentQuestion->rationale !!}
                                            @else
                                                The correct answer is {{ $currentQuestion->correctAnswer }}. Review the explanation to understand the concept.
                                            @endif
                                        </p>
                                        {{-- @if($currentQuestion->resource_url)
                                            <p class="mt-2 text-xs text-muted-foreground">
                                                Source: <a href="{{ $currentQuestion->resource_url }}" target="_blank" rel="noopener" style="color: var(--sage)">{{ parse_url($currentQuestion->resource_url, PHP_URL_HOST) }}</a>
                                            </p>
                                        @endif --}}
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
                                        <button id="c_{{ $choice['letter'] }}" class="w-full text-left flex items-center gap-3 p-4 rounded-xl border transition-all duration-150 hover:scale-[1.01] hover:border-primary/30 choice-button {{ $showCorrectState ? 'choice-button--correct' : '' }} {{ $showIncorrectState ? 'choice-button--incorrect' : '' }}" 
                                                role="radio" 
                                                aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
                                                data-choice="{{ $choice['letter'] }}"
                                                {{ $isAnswered ? 'disabled' : '' }}
                                                onclick="selectAnswer(this)">
                                            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 text-xs font-bold font-inter choice__letter {{ $showCorrectState ? 'border-green-500 bg-green-500 text-white' : ($showIncorrectState ? 'border-red-400 bg-red-50 text-red-600' : 'border-border text-muted-foreground') }}">
                                                {{ $choice['letter'] }}
                                            </div>
                                            <span id="c_t_{{ $choice['letter'] }}" class="text-sm font-medium text-foreground">{{ $choice['text'] }}</span>
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
                    
                    
                    {{-- {{ $answeredCount }} --}}
                    <div class="mt-4 text-center text-xs text-muted-foreground" id="progress-text">
                        <span id="total_answered">{{ $answeredCount }}</span> of {{ $questions->count() }} answered &middot; {{ $correctCount }} correct
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
        window.QuizConfig = {
            totalQuestions: {{ $questions->count() }},
            isLastQuestion: {{ $isLastQuestion ? 'true' : 'false' }},
            csrfToken: '{{ csrf_token() }}',
            isAnswered: {{ $isAnswered ? 'true' : 'false' }},
            answeredCount: {{ $answeredCount }},
            correctCount: {{ $correctCount }},
            questionNumber: {{ $questionNumber }},
            navigateUrl: '{{ route("quiz.navigate") }}'
        };
    </script>
    <script src="{{ asset('js/quiz-pg.js') }}" defer></script>
</body>
</html>