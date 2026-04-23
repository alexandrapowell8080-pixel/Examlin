@php
    $pageTitle = "Results | {$examName->name} | {$exam->name} | {$category->name} | Examlin";
    $pageDesc = "You scored {$percentage}% on {$examName->name}. Review your performance and try again.";
    $pageKeywords = "examlin, {$category->slug}, {$exam->slug}, {$examName->slug}, results, score";
    $canonical = route('quiz.results', [$category->slug, $exam->slug, $examName->slug]);
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
</head>
<body>
     @include('partials.header')

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
                <a class="breadcrumb__link" href="{{ route('quiz.show', [$category->slug, $exam->slug, $examName->slug]) }}">{{ $examName->name }}</a>
                <svg class="breadcrumb__separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                <span class="breadcrumb__current" aria-current="page">Results</span>
            </nav>

            <div class="question-page__header">
                <h1 class="question-page__title">Your Results</h1>
                <p class="question-page__meta">{{ $examName->name }} · {{ $exam->name }} · {{ $category->name }}</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="bg-card border border-border rounded-2xl p-6 md:p-8 text-center">
                        
                        @if($newHighScore)
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="m16.2 7.8 2.9-2.9"/><path d="M18 12h4"/><path d="m16.2 16.2 2.9 2.9"/><path d="M12 18v4"/><path d="m4.9 19.1 2.9-2.9"/><path d="M2 12h4"/><path d="m4.9 4.9 2.9 2.9"/></svg>
                            New High Score!
                        </div>
                        @endif

                        <div class="text-6xl md:text-7xl font-bold text-primary mb-2">{{ $percentage }}%</div>
                        <p class="text-muted-foreground mb-6">Overall Score</p>
                        
                        <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-8">
                            <div class="p-4 rounded-xl bg-offwhite">
                                <div class="text-2xl font-bold text-foreground">{{ $score }}</div>
                                <div class="text-xs text-muted-foreground">Correct</div>
                            </div>
                            <div class="p-4 rounded-xl bg-offwhite">
                                <div class="text-2xl font-bold text-foreground">{{ $total - $score }}</div>
                                <div class="text-xs text-muted-foreground">Incorrect</div>
                            </div>
                        </div>

                        @if($highScore > 0 && $percentage < $highScore)
                        <p class="text-sm text-muted-foreground mb-4">
                            Your best score: <span class="font-semibold text-foreground">{{ $highScore }}%</span>
                        </p>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('quiz.show', [$category->slug, $exam->slug, $examName->slug]) }}" 
                               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary/90 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 12"/></svg>
                                Retry Quiz
                            </a>
                            <a href="{{ route('exam.category', $category->slug) }}" 
                               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-border text-foreground font-semibold hover:bg-accent transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                Back to {{ $category->name }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-card border border-border rounded-2xl p-6">
                        <h3 class="text-sm font-bold text-foreground mb-4">Performance Summary</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Questions Answered</span>
                                <span class="text-sm font-semibold">{{ $total }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Correct Answers</span>
                                <span class="text-sm font-semibold text-green-600">{{ $score }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Accuracy</span>
                                <span class="text-sm font-semibold {{ $percentage >= 70 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $percentage }}%</span>
                            </div>
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
                                    @foreach($navExams->where('id', '!=', $category->id) as $related)
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
    </script>
</body>
</html>