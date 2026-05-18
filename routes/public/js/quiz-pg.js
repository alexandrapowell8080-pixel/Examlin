document.addEventListener('DOMContentLoaded', function() {
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
    
    let correctAnswer = choicesList?.dataset.correctAnswer;
    let questionId = choicesList?.dataset.questionId;
    let alreadyCounted = choicesList?.dataset.alreadyCounted === 'true';
    const examNameId = choicesList?.dataset.examNameId;
    
    // Loaded safely from Blade bridge
    const totalQuestions = window.QuizConfig.totalQuestions;
    const isLastQuestion = window.QuizConfig.isLastQuestion;
    const csrfToken = window.QuizConfig.csrfToken;
    let questionAnswered = window.QuizConfig.isAnswered;
    let currentAnsweredCount = window.QuizConfig.answeredCount;
    let currentCorrectCount = window.QuizConfig.correctCount;
    
    let total_answered = 0;

    window.selectAnswer = function(btn) {
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
                progressEl.innerHTML = `<span id="total_answered">${currentAnsweredCount}</span> of ${totalQuestions} answered &middot; ${currentCorrectCount} correct`;
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
    };
    
    async function navigateQuestion(direction) {
        if (direction === 'next' && !questionAnswered) {
            return;
        }
        
        const btn = direction === 'next' ? nextBtn : prevBtn;
        if (!btn) return;
        
        try {
            const formData = new FormData();
            formData.append('exam_name_id', examNameId);
            formData.append('direction', direction);
            formData.append('_token', csrfToken);
     
            const response = await fetch(window.QuizConfig.navigateUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
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
                nextQuestion();
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
                
                let correctAnswer = newChoicesList.dataset.correctAnswer;
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
                
                let alreadyCounted = newChoicesList.dataset.alreadyCounted === 'true';
                if (!alreadyCounted) {
                    currentAnsweredCount++;
                    if (isCorrect) {
                        currentCorrectCount++;
                    }
                    
                    const progressEl = document.getElementById('progress-text');
                    if (progressEl) {
                        progressEl.innerHTML = `<span id="total_answered">${currentAnsweredCount}</span> of ${totalQuestions} answered &middot; ${currentCorrectCount} correct`;
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
            newNextBtn.onclick = function() { navigateQuestion('next'); };
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

    function nextQuestion(){
        console.log('Fetching next question...', examNameId, questionId);
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
        
            document.getElementById('question-text').innerText = res.question.question;
            
            const ratCard = document.getElementById('rationale-card');
            if(ratCard) ratCard.style.display = 'none';

            let letters = ['A','B','C','D','E','F','G'];
            letters.forEach(element => {
                let btn = document.getElementById('c_'+element);
                let btn_txt = document.getElementById('c_t_'+element); 
                let textSpan = document.getElementById('choice_text'+element);

                    
                if (btn) {
                
                    let choiceText = res.question['choice' + element];
                    
                    if (choiceText) {
                    
                        btn.disabled = false;
                        btn.style.cursor = 'pointer';
                        btn.setAttribute('aria-pressed', 'false');
                        
                        btn.classList.remove('choice-button--correct','choice-button--incorrect','border-primary', 'bg-primary/5', 'text-primary');
                        btn.classList.add('text-muted-foreground','border-border');
                        
                        const letterEl = btn.querySelector('.choice__letter');
                        if (letterEl) {
                            letterEl.classList.remove('border-green-500', 'bg-green-500', 'text-white', 'border-red-400', 'bg-red-50', 'text-red-600');
                            letterEl.classList.add('border-border', 'text-muted-foreground');
                        }
                        
                        if(textSpan) textSpan.innerText = choiceText;
                        btn.style.display = 'flex';
                    } else {
                    
                        btn.disabled = true;
                        btn.style.display = 'none';
                    }

                    btn_txt.innerText = res.question[`choice${element}`];
                }
            });

            total_answered++;
            console.log(document.getElementById('total_answered'));
            
            const progressBar = document.getElementById('progress-bar-fill');
            if (progressBar && totalQuestions > 0) {
            
                const newQNum = (window.QuizConfig.questionNumber + total_answered); 
                const pct = Math.min(100, (newQNum / totalQuestions) * 100);
                progressBar.style.width = pct + '%';
                
                const qText = document.getElementById('question-number-text');
                if(qText) qText.innerText = `Question ${newQNum}`;
            }

            questionId = res.question.id;
            questionAnswered = false; 
            alreadyCounted = false;  
            correctAnswer = res.question.correctAnswer; 
            
            const cl = document.getElementById('choices-list');
            if(cl) {
                cl.dataset.questionId = questionId;
                cl.dataset.correctAnswer = correctAnswer;
                cl.dataset.alreadyCounted = 'false';
            }

            const nBtn = document.getElementById('next-btn');
            if(nBtn) {
                nBtn.disabled = true;
                if(nBtn.tagName === 'A') {
                    nBtn.classList.add('opacity-50', 'pointer-events-none');
                    nBtn.setAttribute('tabindex', '-1');
                }
            }
        })
        .catch(err => console.error('Progress update failed:', err));
    }

    // Initialize the quiz events on load
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
        const percentage = totalQuestions > 0 ? Math.min(100, (window.QuizConfig.questionNumber / totalQuestions) * 100) : 0;
        progressBar.style.width = percentage + '%';
    }

    window.addEventListener('popstate', function() {
        window.location.reload();
    });
});