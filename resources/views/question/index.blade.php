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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                            {{-- <p class="mt-2 text-xs text-muted-foreground">
                                                Source: <a href="{{ $question->resource_url }}" target="_blank" rel="noopener" style="color: var(--sage); text-decoration: underline;">{{ parse_url($question->resource_url, PHP_URL_HOST) }}</a>
                                            </p> --}}
                                        @endif
                                    </div>
                                </div>

                                
                                <div class="mt-6 flex justify-end" id="next-btn-container" style="display: none;">
                                    <button type="button" id="next-question-btn" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span id="next-btn-text">Next Question</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="next-btn-icon"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </button>
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
                                                data-letter="{{ $choice['letter'] }}"
                                                data-is-correct="{{ $isCorrectChoice ? 'true' : 'false' }}">
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
                                                    Practice Question
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtns = document.querySelectorAll("#course-filters .filter-btn");
        const courseGrids = document.querySelectorAll(".course-grids-container .course-grid-3");

        if (filterBtns.length > 0 && courseGrids.length > 0) {
            filterBtns.forEach((btn) => {
                btn.addEventListener("click", function () {
                    filterBtns.forEach((b) => b.classList.remove("active"));
                    this.classList.add("active");
                    const targetId = this.getAttribute("data-target");
                    courseGrids.forEach((grid) => {
                        if (grid.id === targetId) {
                            grid.classList.remove("hidden-grid");
                            grid.classList.add("active-grid");
                        } else {
                            grid.classList.remove("active-grid");
                            grid.classList.add("hidden-grid");
                        }
                    });
                });
            });
        }
        function initWidgetAnimation() {
            const container = document.querySelector(".widget-graphic-container");
            const graphic = document.querySelector(".widget-graphic");
            const items = document.querySelectorAll(".widget-graphic-container .widget-item");
            if (!container || !graphic || items.length === 0) return;
            let currentIndex = -1;
            let animationInterval;
            let isHovering = false;
            function highlightNextItem() {
                items.forEach((item) => item.classList.remove("item-active"));
                let newIndex;
                do { newIndex = Math.floor(Math.random() * items.length); } while (newIndex === currentIndex && items.length > 1);
                currentIndex = newIndex;
                const targetItem = items[currentIndex];
                targetItem.classList.add("item-active");
                const itemLeft = targetItem.offsetLeft;
                const itemTop = targetItem.offsetTop;
                const itemWidth = targetItem.offsetWidth;
                const itemHeight = targetItem.offsetHeight;
                const graphicLeft = itemLeft + itemWidth / 2 - 40;
                const graphicTop = itemTop + itemHeight / 2 - 33;
                graphic.style.left = `${graphicLeft}px`;
                graphic.style.top = `${graphicTop}px`;
            }
            function highlightItemAtIndex(index) {
                items.forEach((item) => item.classList.remove("item-active"));
                currentIndex = index;
                const targetItem = items[currentIndex];
                targetItem.classList.add("item-active");
                const itemLeft = targetItem.offsetLeft;
                const itemTop = targetItem.offsetTop;
                const itemWidth = targetItem.offsetWidth;
                const itemHeight = targetItem.offsetHeight;
                const graphicLeft = itemLeft + itemWidth / 2 - 40;
                const graphicTop = itemTop + itemHeight / 2 - 33;
                graphic.style.left = `${graphicLeft}px`;
                graphic.style.top = `${graphicTop}px`;
            }
            function startAnimation() {
                if (!isHovering) {
                    highlightNextItem();
                    animationInterval = setInterval(highlightNextItem, 900);
                }
            }
            function stopAnimation() {
                if (animationInterval) { clearInterval(animationInterval); animationInterval = null; }
            }
            container.addEventListener("mouseenter", function () { isHovering = true; stopAnimation(); });
            container.addEventListener("mouseleave", function () {
                isHovering = false;
                setTimeout(() => { if (!isHovering) startAnimation(); }, 100);
            });
            items.forEach((item, index) => {
                item.addEventListener("mouseenter", function () {
                    if (isHovering) highlightItemAtIndex(index);
                });
            });
            setTimeout(() => { if (!isHovering) startAnimation(); }, 200);
        }
        initWidgetAnimation();
        function initQuizInteraction() {
            const choicesList = document.getElementById('choices-list');
            const nextBtnContainer = document.getElementById('next-btn-container');
            const nextBtn = document.getElementById('next-question-btn');
            const nextBtnText = document.getElementById('next-btn-text');
            const nextBtnIcon = document.getElementById('next-btn-icon');
            
            if (!choicesList) return;

            const buttons = choicesList.querySelectorAll('.choice-button');
            let hasAnswered = false;
            let selectedAnswer = null;

            function handleAnswerClick(selectedButton) {
                if (hasAnswered) return;
                hasAnswered = true;
                selectedAnswer = selectedButton.dataset.letter;
                buttons.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.remove('hover:scale-[1.01]', 'hover:border-primary/30');
                    btn.style.cursor = 'default';
                    
                    const letterEl = btn.querySelector('.choice__letter');
                    const btnLetter = btn.dataset.letter;
                    const btnIsCorrect = btn.dataset.isCorrect === 'true';

                    if (btnIsCorrect) {
                        btn.classList.add('border-green-500', 'bg-green-50');
                        letterEl.classList.add('bg-green-500', 'text-white', 'border-green-500');
                        letterEl.classList.remove('border-border', 'text-muted-foreground');
                        letterEl.innerHTML = '✓';
                    } else if (btnLetter === selectedAnswer && !btnIsCorrect) {
                        btn.classList.add('border-red-500', 'bg-red-50');
                        letterEl.classList.add('bg-red-500', 'text-white', 'border-red-500');
                        letterEl.classList.remove('border-border', 'text-muted-foreground');
                        letterEl.innerHTML = '✕';
                    } else {
                        btn.style.opacity = '0.5';
                    }
                });
                const rationaleCard = document.querySelector('.rationale-card');
                if (rationaleCard) {
                    rationaleCard.style.transition = 'all 0.3s ease';
                    rationaleCard.style.borderColor = 'rgba(154, 74, 122, 0.8)';
                    rationaleCard.style.backgroundColor = 'rgba(154, 74, 122, 0.12)';
                    rationaleCard.style.boxShadow = '0 0 0 3px rgba(154, 74, 122, 0.1)';
                }
                if (nextBtnContainer) {
                    nextBtnContainer.style.display = 'flex';
                    nextBtn.disabled = false;
                }
            }
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleAnswerClick(this);
                });
            });
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    nextBtn.disabled = true;
                    nextBtnText.textContent = 'Loading...';
                    nextBtnIcon.innerHTML = '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-opacity="0.25" fill="none"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" class="animate-spin"/>';
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    const questionId = choicesList.dataset.questionId;

                    if (!csrfToken || !questionId) {
                        console.error('Missing CSRF token or Question ID');
                        fallbackNavigation();
                        return;
                    }

                    fetch('/question-next', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            question_id: parseInt(questionId)
                        })
                    })
                    .then(async res => {
                        const contentType = res.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server returned non-JSON response');
                        }
                        
                        if (!res.ok) {
                            const err = await res.json().catch(() => ({}));
                            throw new Error(err.error || 'Request failed: ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (!data.success || !data.question) {
                            throw new Error('Invalid response format');
                        }
                        updateQuestionDisplay(data.question);
                    })
                    .catch((error) => {
                        console.error('Next question fetch failed:', error.message);
                        fallbackNavigation();
                    });
                });
            }
            function fallbackNavigation() {
                const relatedLinks = document.querySelectorAll('.related-question-card');
                if (relatedLinks.length > 0) {
                    const randomIndex = Math.floor(Math.random() * relatedLinks.length);
                    window.location.href = relatedLinks[randomIndex].href;
                } else {
                    window.location.href = '/questions/random';
                }
            }
        }
        function updateQuestionDisplay(question) {
            const questionText = document.getElementById('question-text');
            if (questionText && question.question_text) {
                questionText.textContent = question.question_text;
            }
            const extractDiv = document.querySelector('.question-extract');
            if (question.extract) {
                if (extractDiv) {
                    extractDiv.innerHTML = question.extract.replace(/\n/g, '<br>');
                    extractDiv.style.display = 'block';
                }
            } else if (extractDiv) {
                extractDiv.style.display = 'none';
            }
            const imageDiv = document.querySelector('.question-image');
            if (question.image) {
                if (imageDiv) {
                    const img = imageDiv.querySelector('img');
                    if (img) {
                        img.src = '{{ asset("storage/") }}' + question.image;
                    }
                    imageDiv.style.display = 'block';
                }
            } else if (imageDiv) {
                imageDiv.style.display = 'none';
            }
            const rationaleText = document.getElementById('rationale-text');
            if (rationaleText) {
                rationaleText.innerHTML = question.rationale || `The correct answer is ${question.correctAnswer}.`;
            }
            const choicesList = document.getElementById('choices-list');
            if (choicesList && question.choices && Array.isArray(question.choices)) {
                choicesList.dataset.correctAnswer = question.correctAnswer;
                choicesList.dataset.questionId = question.id;
                choicesList.dataset.slug = question.slug;
                choicesList.innerHTML = '';
                question.choices.forEach(choice => {
                    const btn = document.createElement('button');
                    btn.className = `w-full text-left flex items-center gap-3 p-4 rounded-xl border transition-all duration-150 hover:scale-[1.01] hover:border-primary/30 choice-button`;
                    btn.setAttribute('role', 'radio');
                    btn.setAttribute('aria-pressed', 'false');
                    btn.dataset.letter = choice.letter;
                    btn.dataset.isCorrect = choice.is_correct ? 'true' : 'false';
                    
                    const letterDiv = document.createElement('div');
                    letterDiv.className = `w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 text-xs font-bold font-inter choice__letter border-border text-muted-foreground`;
                    letterDiv.textContent = choice.letter;
                    
                    const textSpan = document.createElement('span');
                    textSpan.className = 'text-sm font-medium text-foreground';
                    textSpan.textContent = choice.text;
                    
                    btn.appendChild(letterDiv);
                    btn.appendChild(textSpan);
                    choicesList.appendChild(btn);
                });
            }
            const rationaleCard = document.querySelector('.rationale-card');
            if (rationaleCard) {
                rationaleCard.style.borderColor = 'rgba(154, 74, 122, 0.25)';
                rationaleCard.style.backgroundColor = 'rgba(154, 74, 122, 0.07)';
                rationaleCard.style.boxShadow = 'none';
            }
            
            const nextBtnContainer = document.getElementById('next-btn-container');
            if (nextBtnContainer) {
                nextBtnContainer.style.display = 'none';
            }
            const nextBtn = document.getElementById('next-question-btn');
            if (nextBtn) {
                nextBtn.disabled = false;
            }
            if (nextBtnText) {
                nextBtnText.textContent = 'Next Question';
            }
            if (nextBtnIcon) {
                nextBtnIcon.innerHTML = '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>';
            }
            initQuizInteraction();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        initQuizInteraction();
    });
    </script>
</body>
</html>