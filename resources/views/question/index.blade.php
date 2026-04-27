@php
    $pageTitle = "Practice Question | Examlin";
    $pageDesc = strip_tags(substr($question->question, 0, 160)) . '...';
    $canonical = $question->resource_url ?: route('question.show', $question->slug);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <link rel="canonical" href="{{ $canonical }}">
    
    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Question",
        "name": "Practice Question",
        "text": "{{ strip_tags($question->question) }}",
        "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Option {{ $question->correctAnswer }}"
        }
    }
    </script>
</head>
<body>
    @include('partials.header')
    
    <main class="question-page">
        <div class="container" id="quiz-container">

            <div class="question-page__header">
                <h1 class="question-page__title">Practice Question</h1>
                <p class="question-page__meta">Individual Practice · Free</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="grid lg:grid-cols-5 gap-6">
                        
                        <div class="lg:col-span-3">
                            <div class="bg-card border border-border rounded-2xl p-6 md:p-8">
                                
                                @if($question->extract)
                                    <div class="question-extract mb-4 p-4 rounded-xl bg-offwhite border-l-4" style="border-left-color: var(--sage)">
                                        {!! nl2br(e($question->extract)) !!}
                                    </div>
                                @endif
                                
                                <p class="text-lg md:text-xl font-semibold text-foreground leading-relaxed font-inter" id="question-text">{{ $question->question }}</p>
                                
                                @if($question->image)
                                    <div class="question-image mt-4 text-center">
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question illustration" loading="lazy" class="max-w-full h-auto rounded-xl">
                                    </div>
                                @endif

                                <div class="mt-6 rounded-xl p-4 flex gap-3 rationale-card" 
                                     style="background-color: rgba(154, 74, 122, 0.07); border: 1.5px solid rgba(154, 74, 122, 0.25);">
                                    <div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center mt-0.5" style="background-color: rgba(154, 74, 122, 0.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lightbulb w-4 h-4" style="color: rgb(154, 74, 122);"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-widest font-inter mb-1" style="color: rgb(154, 74, 122);">Rationale</p>
                                        <p class="text-sm leading-relaxed text-foreground font-inter" id="rationale-text">
                                            @if($question->rationale)
                                                {!! $question->rationale !!}
                                            @else
                                                The correct answer is {{ $question->correctAnswer }}.
                                            @endif
                                        </p>
                                        @if($question->resource_url)
                                            <p class="mt-2 text-xs text-muted-foreground">
                                                Source: <a href="{{ $question->resource_url }}" target="_blank" rel="noopener" style="color: var(--sage); text-decoration: underline;">{{ parse_url($question->resource_url, PHP_URL_HOST) }}</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-2">
                            <div class="space-y-4">
                                
                                <div class="space-y-2" id="choices-list" 
                                     data-correct-answer="{{ $question->correctAnswer }}"
                                     data-question-id="{{ $question->id }}"
                                     data-slug="{{ $question->slug }}">
                                    
                                    @foreach($choices as $choice)
                                        @php
                                            $isCorrectChoice = $choice['is_correct'];
                                        @endphp
                                        <button class="w-full text-left flex items-center gap-3 p-4 rounded-xl border transition-all duration-150 hover:scale-[1.01] hover:border-primary/30 choice-button {{ $isCorrectChoice ? 'choice-button--correct' : '' }}" 
                                                role="radio" 
                                                aria-pressed="{{ $isCorrectChoice ? 'true' : 'false' }}"
                                                disabled>
                                            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 text-xs font-bold font-inter choice__letter {{ $isCorrectChoice ? 'border-green-500 bg-green-500 text-white' : 'border-border text-muted-foreground' }}">
                                                {{ $choice['letter'] }}
                                            </div>
                                            <span class="text-sm font-medium text-foreground">{{ $choice['text'] }}</span>
                                        </button>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    @if($relatedQuestions->isNotEmpty())
    <div class="mt-12 pt-8 border-t border-border">
        <h2 class="text-lg font-bold text-foreground font-inter mb-4">Related Questions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($relatedQuestions as $related)
                <a href="{{ route('question.show', $related->slug) }}" 
                   class="related-question-card flex items-start gap-3 p-4 rounded-xl border border-border bg-card hover:border-primary/40 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text text-primary"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-foreground line-clamp-2 group-hover:text-primary transition-colors">{{ strip_tags($related->question) }}</p>
                        <p class="mt-1.5 text-xs text-muted-foreground">
                            @if($related->exam_name_id)
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                                    {{ $related->exam_name_id }}
                                </span>
                            @else
                                Practice Question
                            @endif
                        </p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right text-muted-foreground group-hover:text-primary flex-shrink-0 mt-1 transition-colors"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @endforeach
        </div>
    </div>
@endif

                </div>
                
                <div class="hidden lg:block">
                    <div class="sticky top-24">
                        <div class="space-y-6">
                            
                            <div class="bg-card border border-border rounded-2xl p-4">
                                <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider font-inter mb-3">Related Exams</h3>
                                <div class="space-y-1">
                                    @foreach($relatedExams as $related)
                                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-sm text-muted-foreground hover:bg-accent hover:text-foreground transition-all duration-150" 
                                       href="{{ route('exam.category', $related->slug) }}">
                                        <span>{{ $related->name ?? $related->title }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-3 h-3"><path d="m9 18 6-6-6-6"></path></svg>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="bg-card border border-border rounded-2xl p-4">
                                <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-wider font-inter mb-3">Explore More</h3>
                                <div class="space-y-1">
                                    <a class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-muted-foreground hover:bg-accent hover:text-foreground transition-all duration-150" href="/">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home w-3.5 h-3.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        Homepage
                                    </a>
                                    <a class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-muted-foreground hover:bg-accent hover:text-foreground transition-all duration-150" href="/about">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-3.5 h-3.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        About Us
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>