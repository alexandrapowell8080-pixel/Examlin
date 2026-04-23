<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{asset ('images/logo.png') }}" rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>Examlin</title>
    
    <meta content="A comprehensive, high-speed practice platform for U.S. entry exams, providing realistic questions and interactive quizzes to help students master nursing, graduate, and college placement tests." name="description">
    
    <meta content="Examlin" property="og:title">
    <meta content="A comprehensive, high-speed practice platform for U.S. entry exams, providing realistic questions and interactive quizzes to help students master nursing, graduate, and college placement tests." property="og:description">
    <meta content="{{asset ('images/logo.png') }}" property="og:image">
    <meta content="https://examlin.com/" property="og:url">
    <meta content="website" property="og:type">
    <meta content="Examlin" property="og:site_name">
    <meta content="Examlin" name="twitter:title">
    <meta content="A comprehensive, high-speed practice platform for U.S. entry exams, providing realistic questions and interactive quizzes to help students master nursing, graduate, and college placement tests." name="twitter:description">
    <meta content="{{asset ('images/logo.png') }}" name="twitter:image">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="https://examlin.com/" name="twitter:url">
    
    <meta content="yes" name="mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="Examlin" name="apple-mobile-web-app-title">
    <link href="https://examlin.com/" rel="canonical">

    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>
<body class="bg-main font-inter">
    <div id="root">
        <div class="page-wrapper">
            
            @include('partials.header')

            <section class="hero-section">
                <div class="hero-bg"></div>
                <div class="hero-overlay"></div>
                <div class="examlin-container hero-content">
                    <div class="hero-grid">
                        
                        <div class="hero-text-block">
                            <div class="hero-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg>
                                10+ U.S. Entry Exams Covered
                            </div>
                            <h1 class="hero-title">Practice for Every Major Entry Exam — <span class="text-primary">All in One Place</span></h1>
                            <p class="hero-subtitle">From high school equivalency to graduate admissions and nursing pathways, access realistic practice questions and exam-focused quizzes.</p>
                            <p class="hero-desc">Whether you're starting your journey, advancing your career, or switching paths, Examlin helps you prepare smarter.</p>
                            
                            <div class="hero-actions">
                                <a href="/#courses" class="btn btn-primary">
                                    Start Practicing
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                </a>
                                <a href="/#courses" class="btn btn-outline-light">Browse All Exams</a>
                            </div>
                        </div>

                        <div class="hero-widget-desktop">
                            <div class="widget-card">
                                <div class="widget-header">
                                    <p class="widget-title">All Practice Exams</p>
                                    <span class="widget-badge">Free Access</span>
                                </div>
                                <div class="widget-graphic-container">
                                    <div class="widget-graphic">
                                        <div class="graphic-circle">
                                            <div class="graphic-highlight-1"></div>
                                            <div class="graphic-highlight-2"></div>
                                        </div>
                                        <div class="graphic-beam"></div>
                                    </div>
                                    <div class="widget-grid">
                                        <a href="/teas" class="widget-item">TEAS®</a>
                                        <a href="/ged" class="widget-item">GED®</a>
                                        <a href="/nex" class="widget-item">NEX®</a>
                                        <a href="/accuplacer" class="widget-item">ACCUPLACER®</a>
                                        <a href="/gre" class="widget-item">GRE®</a>
                                    </div>
                                    <div class="widget-grid mt-sm">
                                        <a href="/hesi" class="widget-item">HESI A2®</a>
                                        <a href="/lsat" class="widget-item item-active">LSAT®</a>
                                        <a href="/hiset" class="widget-item">HiSET®</a>
                                        <a href="/tsia2" class="widget-item">TSIA2®</a>
                                        <a href="/gmat" class="widget-item">GMAT®</a>
                                    </div>
                                </div>
                                <p class="widget-footer-text">Click any exam to start practicing instantly</p>
                            </div>
                            
                            <div class="widget-floating-stat">
                                <div class="stat-icon-circle">
                                    <span>50K</span>
                                </div>
                                <div>
                                    <p class="stat-main-text">Students Practicing</p>
                                    <p class="stat-sub-text">Daily active learners</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="hero-widget-mobile">
                        <p class="widget-title mb-md">All Practice Exams</p>
                        <div class="mobile-widget-list">
                            <a href="/gmat" class="mobile-widget-item">GMAT®</a>
                            <a href="/gre" class="mobile-widget-item">GRE®</a>
                            <a href="/lsat" class="mobile-widget-item">LSAT®</a>
                            <a href="/teas" class="mobile-widget-item">TEAS®</a>
                            <a href="/hesi" class="mobile-widget-item">HESI A2®</a>
                            <a href="/nex" class="mobile-widget-item">NEX®</a>
                            <a href="/ged" class="mobile-widget-item">GED®</a>
                            <a href="/hiset" class="mobile-widget-item">HiSET®</a>
                            <a href="/accuplacer" class="mobile-widget-item">ACCUPLACER®</a>
                            <a href="/tsia2" class="mobile-widget-item">TSIA2®</a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="courses" class="section-light">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-primary">Practice by Category</span>
                        <h2 class="section-title">Choose Your Exam</h2>
                        <p class="section-desc">Select a category to browse available practice exams and start preparing today.</p>
                    </div>
                    
                    <div class="category-filters" id="course-filters">
                        <button class="filter-btn active" data-target="grid-graduate">Graduate Exams</button>
                        <button class="filter-btn" data-target="grid-nursing">Nursing Exams</button>
                        <button class="filter-btn" data-target="grid-college">College Placement</button>
                        <button class="filter-btn" data-target="grid-hs">High School Equivalency</button>
                    </div>

                    <div class="course-grids-container">
                        <div class="course-grid-3 active-grid" id="grid-graduate">
                            <a href="/gmat" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/586e1612a_generated_91c2a338.webp') }}" alt="GMAT®">
                                </div>
                                <div class="card-body">
                                    <h3>GMAT®</h3>
                                    <p>Prepare for the Graduate Management Admission Test with practice questions covering quantitative, verbal, and integrated reasoning.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/gre" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/e0a6e88fb_generated_73ba4d62.webp') }}" alt="GRE®">
                                </div>
                                <div class="card-body">
                                    <h3>GRE®</h3>
                                    <p>Master the Graduate Record Examination with targeted practice in verbal reasoning, quantitative reasoning, and analytical writing.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/lsat" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/191576a1b_generated_9c2e5bdc.webp') }}" alt="LSAT®">
                                </div>
                                <div class="card-body">
                                    <h3>LSAT®</h3>
                                    <p>Ace the Law School Admission Test with practice on logical reasoning, analytical reasoning, and reading comprehension.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                        </div>

                        <div class="course-grid-3 hidden-grid" id="grid-nursing">
                            <a href="/teas" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/549376d8a_generated_55df93d0.webp') }}" alt="TEAS®">
                                </div>
                                <div class="card-body">
                                    <h3>TEAS®</h3>
                                    <p>Get ready for the Test of Essential Academic Skills with practice in reading, math, science, and English & language usage.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/hesi" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/3427aaba9_generated_c34fa82a.webp') }}" alt="HESI A2®">
                                </div>
                                <div class="card-body">
                                    <h3>HESI A2®</h3>
                                    <p>Prepare for the Health Education Systems Incorporation Admission Assessment with comprehensive practice questions.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/nex" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/d3c08301f_generated_2ddfc8f9.webp') }}" alt="NEX®">
                                </div>
                                <div class="card-body">
                                    <h3>NEX®</h3>
                                    <p>Practice for the Nursing Entrance Exam with questions covering math, science, reading, and English proficiency.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                        </div>

                        <div class="course-grid-3 hidden-grid" id="grid-college">
                            <a href="/accuplacer" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/c9834f674_generated_be062126.webp') }}" alt="ACCUPLACER®">
                                </div>
                                <div class="card-body">
                                    <h3>ACCUPLACER®</h3>
                                    <p>Prepare for college placement with practice questions in reading, writing, and math to ensure proper course placement.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/tsia2" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/93dbcfcd1_generated_7e9e6eb1.webp') }}" alt="TSIA2®">
                                </div>
                                <div class="card-body">
                                    <h3>TSIA2®</h3>
                                    <p>Get ready for the Texas Success Initiative Assessment with practice in English language arts, reading, and mathematics.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                        </div>

                        <div class="course-grid-3 hidden-grid" id="grid-hs">
                            <a href="/ged" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/db67b4372_generated_4034987d.webp') }}" alt="GED®">
                                </div>
                                <div class="card-body">
                                    <h3>GED®</h3>
                                    <p>Earn your high school equivalency with practice tests in mathematical reasoning, science, social studies, and language arts.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                            <a href="/hiset" class="course-card-simple">
                                <div class="card-img-wrapper">
                                    <img src="{{ asset('images/exams/bfdc73159_generated_d4fd3c8c.webp') }}" alt="HiSET®">
                                </div>
                                <div class="card-body">
                                    <h3>HiSET®</h3>
                                    <p>Prepare for the High School Equivalency Test with practice in language arts, math, science, and social studies.</p>
                                    <div class="card-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="stats-banner">
                <div class="examlin-container py-md">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <p class="stat-number">10+</p>
                            <p class="stat-label">Entry Exams</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">500+</p>
                            <p class="stat-label">Practice Questions</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">50K+</p>
                            <p class="stat-label">Students Helped</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">100%</p>
                            <p class="stat-label">Free Access</p>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-secondary">How It Works</span>
                        <h2 class="section-title">Three steps to exam confidence</h2>
                    </div>
                    
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-connector"></div>
                            <div class="step-header">
                                <div class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg></div>
                                <span class="step-number">01</span>
                            </div>
                            <h3>Choose Your Exam</h3>
                            <p>Browse our library of 10+ U.S. entry exams — from GED and HiSET to GMAT, LSAT, and nursing pathways.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-connector"></div>
                            <div class="step-header">
                                <div class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4.1 12 6"></path><path d="m5.1 8-2.9-.8"></path><path d="m6 12-1.9 2"></path><path d="M7.2 2.2 8 5.1"></path><path d="M9.037 9.69a.498.498 0 0 1 .653-.653l11 4.5a.5.5 0 0 1-.074.949l-4.349 1.041a1 1 0 0 0-.74.739l-1.04 4.35a.5.5 0 0 1-.95.074z"></path></svg></div>
                                <span class="step-number">02</span>
                            </div>
                            <h3>Pick a Subject & Quiz</h3>
                            <p>Each exam is broken into focused subjects, with 5 free practice tests per subject — no account needed.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-header">
                                <div class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg></div>
                                <span class="step-number">03</span>
                            </div>
                            <h3>Practice & Improve</h3>
                            <p>Answer questions, get instant feedback, and track your progress with clear correct/incorrect indicators.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-white">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-primary">Our Exams</span>
                        <h2 class="section-title">Every major U.S. entry exam, covered</h2>
                        <p class="section-desc">From graduate admissions to nursing and high school equivalency — we've got you.</p>
                    </div>

                    <div class="course-grid-4">
                        <a href="/gmat" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-gmat"><span>GMAT</span></div>
                                <div>
                                    <h3>GMAT®</h3>
                                    <span class="exam-tag tag-primary">Graduate</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Prepare for the Graduate Management Admission Test with practice questions covering quantitative, verbal, and integrated reasoning.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>2h 15m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>3 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Quantitative Reasoning</span><span>Verbal Reasoning</span><span>Integrated Reasoning</span><span>Analytical Writing</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> MBA applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/gre" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-gre"><span>GRE</span></div>
                                <div>
                                    <h3>GRE®</h3>
                                    <span class="exam-tag tag-primary">Graduate</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Master the Graduate Record Examination with targeted practice in verbal reasoning, quantitative reasoning, and analytical writing.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>1h 58m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>3 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Verbal Reasoning</span><span>Quantitative Reasoning</span><span>Analytical Writing</span><span>Vocabulary</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Grad school applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/lsat" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-lsat"><span>LSAT</span></div>
                                <div>
                                    <h3>LSAT®</h3>
                                    <span class="exam-tag tag-primary">Graduate</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Ace the Law School Admission Test with practice on logical reasoning, analytical reasoning, and reading comprehension.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>2h 20m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Logical Reasoning</span><span>Analytical Reasoning</span><span>Reading Comprehension</span><span>Writing Sample</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Law school applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/teas" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-teas"><span>TEAS</span></div>
                                <div>
                                    <h3>TEAS®</h3>
                                    <span class="exam-tag tag-secondary">Nursing</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Get ready for the Test of Essential Academic Skills with practice in reading, math, science, and English & language usage.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>3h 29m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Reading</span><span>Math</span><span>Science</span><span>English</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Nursing program applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>
                        
                        <a href="/hesi" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-hesi"><span>HESI</span></div>
                                <div>
                                    <h3>HESI A2®</h3>
                                    <span class="exam-tag tag-secondary">Nursing</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Prepare for the Health Education Systems Incorporation Admission Assessment with comprehensive practice questions.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>~5h 15m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Math</span><span>Reading Comprehension</span><span>Vocabulary</span><span>Anatomy & Physiology</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Nursing school applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/nex" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-nex"><span>NEX</span></div>
                                <div>
                                    <h3>NEX®</h3>
                                    <span class="exam-tag tag-secondary">Nursing</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Practice for the Nursing Entrance Exam with questions covering math, science, reading, and English proficiency.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>~3h</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Math</span><span>Science</span><span>Reading</span><span>English</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Nursing entrance applicants
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/accuplacer" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-acc"><span>ACC</span></div>
                                <div>
                                    <h3>ACCUPLACER®</h3>
                                    <span class="exam-tag tag-primary">College</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Prepare for college placement with practice questions in reading, writing, and math to ensure proper course placement.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>Untimed</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Reading</span><span>Writing</span><span>Math</span><span>ESL</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> College placement students
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/tsia2" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-tsia"><span>TSIA</span></div>
                                <div>
                                    <h3>TSIA2®</h3>
                                    <span class="exam-tag tag-primary">College</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Get ready for the Texas Success Initiative Assessment with practice in English language arts, reading, and mathematics.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>~3h</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>English Language Arts</span><span>Reading</span><span>Mathematics</span><span>Essay</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Texas college students
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/ged" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-ged"><span>GED</span></div>
                                <div>
                                    <h3>GED®</h3>
                                    <span class="exam-tag tag-secondary">High School</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Earn your high school equivalency with practice tests in mathematical reasoning, science, social studies, and language arts.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>~7h 30m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Mathematical Reasoning</span><span>Science</span><span>Social Studies</span><span>Language Arts</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Adults without a diploma
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>

                        <a href="/hiset" class="exam-card">
                            <div class="exam-card-header">
                                <div class="exam-logo bg-hiset"><span>HiSET</span></div>
                                <div>
                                    <h3>HiSET®</h3>
                                    <span class="exam-tag tag-secondary">High School</span>
                                </div>
                            </div>
                            <div class="exam-divider"></div>
                            <div class="exam-card-body">
                                <p>Prepare for the High School Equivalency Test with practice in language arts, math, science, and social studies.</p>
                                <div class="exam-details-grid">
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Duration</div>
                                        <p>~7h 25m</p>
                                    </div>
                                    <div class="detail-box">
                                        <div class="detail-label"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line></svg> Sections</div>
                                        <p>4 sections</p>
                                    </div>
                                </div>
                                <div class="exam-pills">
                                    <span>Language Arts - Reading</span><span>Language Arts - Writing</span><span>Mathematics</span><span>Science</span>
                                </div>
                                <div class="exam-audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg> Adults seeking equivalency
                                </div>
                                <div class="exam-link">Start Practice <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></div>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </section>

            <section class="section-dark">
                <div class="examlin-container py-lg">
                    <div class="feature-grid">
                        <div class="feature-text-block">
                            <span class="section-badge badge-secondary mb-md">Why Examlin</span>
                            <h2 class="feature-title">Built for focused, <span class="text-primary">results-driven</span> exam prep</h2>
                            <p class="feature-desc">Examlin strips away everything that doesn't help you pass. Clean interface, real questions, immediate feedback — that's it. No distractions, no fluff.</p>
                            <a href="/#courses" class="btn btn-primary">Start Practicing Free</a>
                        </div>
                        <div class="feature-cards">
                            <div class="feature-card">
                                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg></div>
                                <h4>Exam-Focused Questions</h4>
                                <p>Every question is written to mirror real exam style, difficulty, and format — no filler content.</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg></div>
                                <h4>Instant Feedback</h4>
                                <p>See correct and incorrect answers immediately after each selection. No waiting for results.</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect></svg></div>
                                <h4>Organized by Subject</h4>
                                <p>Each exam is broken into clearly labeled subjects so you can focus on exactly what you need.</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg></div>
                                <h4>Always Free</h4>
                                <p>All practice tests are free. No account required, no hidden paywalls, no subscriptions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="cta-banner">
                        <h2 class="cta-title">Ready to start practicing?</h2>
                        <p class="cta-desc">Pick your exam, choose a subject, and begin with your first free practice test — no sign-up required.</p>
                        <a href="/#courses" class="btn btn-dark">
                            Browse All Exams
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </section>

            <div class="disclaimer-area">
                <p>SAT® is a registered trademark of the College Entrance Examination Board™. The College Entrance Examination Board™ does not endorse, nor is it affiliated in any way with the owner or any content of this website. ACT® is a registered trademark belonging to ACT Education Corporation ("ACT"). ACT is not involved with or affiliated with PrepScholar Inc, nor does ACT endorse or sponsor any of the products or services offered by PrepScholar Inc. GRE® and TOEFL® are registered trademarks of the ETS®. The ETS® does not endorse, nor is it affiliated in any way with, the owner or any content of this website. GMAT® is a registered trademark of the Graduate Management Admissions Council®. The Graduate Management Admissions Council® does not endorse, nor is it affiliated in any way with, the owner or any content of this website.</p>
            </div>

            @include('partials.footer')

        </div>
    </div>
</body>
</html>