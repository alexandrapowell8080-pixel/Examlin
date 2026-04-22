<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>About Us | Examlin</title>
    
    <meta content="Examlin is a focused exam preparation platform built to help students confidently prepare for major U.S. entry exams with free, structured practice." name="description">
    
    <meta content="About Examlin" property="og:title">
    <meta content="Examlin is a focused exam preparation platform built to help students confidently prepare for major U.S. entry exams with free, structured practice." property="og:description">
    <meta content="{{ asset('images/logo.png') }}" property="og:image">
    <meta content="{{ url()->current() }}" property="og:url">
    <meta content="website" property="og:type">
    <meta content="Examlin" property="og:site_name">
    <meta content="About Examlin" name="twitter:title">
    <meta content="Examlin is a focused exam preparation platform built to help students confidently prepare for major U.S. entry exams with free, structured practice." name="twitter:description">
    <meta content="{{ asset('images/logo.png') }}" name="twitter:image">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="{{ url()->current() }}" name="twitter:url">
    
    <meta content="yes" name="mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="Examlin" name="apple-mobile-web-app-title">
    <link href="{{ url()->current() }}" rel="canonical">

    <link rel="stylesheet" href="{{ asset('css/examlin-partials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>
<body class="bg-main font-inter">
    <div id="root">
        <div class="page-wrapper">
            
            @include('partials.header')

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-primary">About Examlin</span>
                        <h1 class="section-title">Who We Are</h1>
                        <p class="section-desc" style="max-width: 800px; margin: 0 auto;">
                            Examlin is a focused exam preparation platform built to help students confidently prepare for major U.S. entry exams. 
                            From high school equivalency tests to graduate admissions and nursing entrance exams, Examlin provides structured, exam-specific practice designed for real results.
                        </p>
                        <p class="section-desc" style="max-width: 800px; margin: 1rem auto 0;">
                            We exist to simplify preparation. Instead of overwhelming users with unnecessary content, Examlin delivers what matters most — targeted practice questions, organized by subject, aligned with real exam formats, and accessible instantly.
                        </p>
                    </div>
                </div>
            </section>

            <section class="section-white">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <h2 class="section-title">What We Do</h2>
                        <p class="section-desc">Examlin provides free access to practice questions across more than 10 major U.S. entry exams, including:</p>
                    </div>
                    
                    <div class="exam-pills" style="justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">GMAT®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">GRE®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">LSAT®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">TEAS®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">HESI A2®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">NEX®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">GED®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">HiSET®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">ACCUPLACER®</span>
                        <span style="font-size: 1rem; padding: 0.5rem 1rem;">TSIA2®</span>
                    </div>

                    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                        <p style="margin-bottom: 1.5rem; color: var(--text-muted); line-height: 1.6;">
                            Each exam is broken down into clearly defined subjects, and each subject contains multiple practice quizzes designed to reflect the structure, style, and difficulty of actual exam questions.
                        </p>
                        <h3 style="font-size: 1.25rem; color: var(--brand-dark); margin-bottom: 1rem;">Our approach is simple:</h3>
                        <div class="exam-pills" style="justify-content: center; flex-wrap: wrap;">
                            <span class="tag-primary">Focused content</span>
                            <span class="tag-primary">Immediate feedback</span>
                            <span class="tag-primary">Clear structure</span>
                            <span class="tag-primary">No unnecessary barriers</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <span class="section-badge badge-secondary">Our Mission</span>
                        <h2 class="section-title">Accessible, efficient, and effective for everyone</h2>
                        <p class="section-desc" style="max-width: 800px; margin: 0 auto;">
                            We believe that preparing for an important exam should not require expensive subscriptions, complex tools, or overwhelming study systems.
                        </p>
                        <p class="section-desc" style="max-width: 800px; margin: 1rem auto 0;">
                            Instead, students should be able to access relevant practice instantly, focus on specific subjects, learn through repetition and feedback, and build confidence through consistent practice.
                        </p>
                    </div>
                </div>
            </section>

            <section class="section-white">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <h2 class="section-title">How Examlin Works</h2>
                        <p class="section-desc">Examlin is designed around a simple, effective learning flow:</p>
                    </div>
                    
                    <div class="steps-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
                        <div class="step-card">
                            <div class="step-connector"></div>
                            <div class="step-header">
                                <span class="step-number" style="background: var(--bg-light); padding: 4px 8px; border-radius: 4px;">1</span>
                            </div>
                            <h3>Choose Your Exam</h3>
                            <p>Select from a wide range of entry exams across graduate, nursing, college placement, and high school equivalency categories.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-connector"></div>
                            <div class="step-header">
                                <span class="step-number" style="background: var(--bg-light); padding: 4px 8px; border-radius: 4px;">2</span>
                            </div>
                            <h3>Pick a Subject</h3>
                            <p>Each exam is divided into core subjects such as math, reading, science, or reasoning.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-connector"></div>
                            <div class="step-header">
                                <span class="step-number" style="background: var(--bg-light); padding: 4px 8px; border-radius: 4px;">3</span>
                            </div>
                            <h3>Start Practicing</h3>
                            <p>Each subject contains multiple quizzes with realistic questions. Users can begin immediately without signing up.</p>
                        </div>
                        <div class="step-card">
                            <div class="step-header">
                                <span class="step-number" style="background: var(--bg-light); padding: 4px 8px; border-radius: 4px;">4</span>
                            </div>
                            <h3>Get Instant Feedback</h3>
                            <p>Every answer provides immediate correct or incorrect feedback, allowing users to learn and adjust in real time.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-dark">
                <div class="examlin-container py-lg">
                    <div class="section-header center" style="margin-bottom: 3rem;">
                        <h2 class="section-title" style="color: #fff;">What Makes Examlin Different</h2>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.125rem;">Focused, Exam-Relevant Content</h4>
                            <p style="color: var(--footer-text); font-size: 0.875rem;">Every question is designed to reflect real exam patterns and expectations. There is no filler content or unrelated material.</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.125rem;">Structured Learning</h4>
                            <p style="color: var(--footer-text); font-size: 0.875rem;">Content is organized by exam and subject, making it easy to target weak areas and improve efficiently.</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.125rem;">Immediate Feedback</h4>
                            <p style="color: var(--footer-text); font-size: 0.875rem;">Users receive instant results after each question, reinforcing learning and improving retention.</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.125rem;">Completely Free Access</h4>
                            <p style="color: var(--footer-text); font-size: 0.875rem;">All practice questions are accessible without subscriptions, paywalls, or mandatory accounts.</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 8px;">
                            <h4 style="color: #fff; margin-bottom: 0.5rem; font-size: 1.125rem;">Fast and Simple Experience</h4>
                            <p style="color: var(--footer-text); font-size: 0.875rem;">The platform is built for speed and clarity. Users can start practicing within seconds.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
                        
                        <div>
                            <h3 style="font-size: 1.5rem; color: var(--brand-dark); margin-bottom: 1rem; font-weight: 700;">Who Examlin Is For</h3>
                            <p style="color: var(--text-muted); margin-bottom: 1rem;">Examlin supports a wide range of learners, including:</p>
                            <ul style="color: var(--text-muted); padding-left: 1.5rem; line-height: 1.8;">
                                <li>Students preparing for graduate school entrance exams</li>
                                <li>Nursing applicants preparing for entrance or assessment tests</li>
                                <li>Individuals taking college placement exams</li>
                                <li>Adults pursuing high school equivalency credentials</li>
                                <li>Anyone looking for structured, exam-focused practice</li>
                            </ul>
                        </div>

                        <div>
                            <h3 style="font-size: 1.5rem; color: var(--brand-dark); margin-bottom: 1rem; font-weight: 700;">Our Approach to Quality </h3>
                            <p style="color: var(--text-muted); margin-bottom: 1rem; line-height: 1.6;">
                                Examlin prioritizes clarity, relevance, and usability in all content. Practice questions are designed to reflect real exam formats, cover key subject areas, maintain appropriate difficulty levels, and support learning through repetition and feedback. 
                            </p>
                            <p style="color: var(--text-muted); line-height: 1.6;">
                                We continuously refine content to ensure it remains useful, accurate, and aligned with exam expectations. 
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section-white">
                <div class="examlin-container py-lg">
                    <div class="section-header center">
                        <h2 class="section-title">Frequently Asked Questions (FAQs) </h2>
                    </div>
                    
                    <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Is Examlin free to use? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Yes. Examlin provides free access to all practice questions and quizzes.  There are no required subscriptions, hidden fees, or mandatory account registrations. </p>
                        </div>
                        
                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Do I need to create an account to start practicing? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">No. Users can begin practicing immediately without creating an account. The platform is designed for instant access. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Are the questions similar to real exam questions? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Examlin questions are designed to reflect the structure, format, and difficulty of real exam questions.  While they are not official exam questions, they are created to simulate the exam experience as closely as possible. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Which exams are covered on Examlin? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Examlin currently covers over 10 major U.S. entry exams, including graduate exams, nursing exams, college placement tests, and high school equivalency exams. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">How are the quizzes structured? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Each subject within an exam contains multiple quizzes. Each quiz includes a set of questions designed to test understanding of that specific subject area. Users can move between quizzes and subjects freely. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Can I track my progress? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Users receive immediate feedback on each question. While the platform focuses on simplicity and instant practice, performance feedback helps users identify strengths and areas for improvement. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Is Examlin affiliated with official exam organizations? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">No. Examlin is an independent platform and is not affiliated with or endorsed by any official exam organizations.  All trademarks belong to their respective owners. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Who creates the questions on Examlin? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Questions are developed to align with exam standards and subject expectations.  They are structured to provide meaningful practice and reinforce learning across core topics. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Can I use Examlin as my primary study resource? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Examlin is designed as a powerful practice tool. It is most effective when used alongside other study materials such as textbooks, courses, or official exam guides. </p>
                        </div>

                        <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Is Examlin suitable for beginners? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Yes. The platform is designed to be accessible to users at different levels.  Beginners can start with basic practice and gradually build confidence through repeated exposure. </p>
                        </div>

                        <div>
                            <h4 style="font-size: 1.125rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 600;">Why is Examlin focused on simplicity? </h4>
                            <p style="color: var(--text-muted); line-height: 1.6;">Examlin removes unnecessary complexity to help users focus on what matters most — practicing questions and improving performance.  This approach reduces distractions and improves efficiency. </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-light">
                <div class="examlin-container py-lg">
                    <div class="cta-banner">
                        <h2 class="cta-title">Your next step starts here </h2>
                        <p class="cta-desc" style="margin-bottom: 1rem;">Examlin is built around one principle: effective preparation should be simple, focused, and accessible. </p>
                        <p class="cta-desc" style="margin-bottom: 2rem;">By combining structured practice, realistic questions, and immediate feedback, Examlin helps learners take meaningful steps toward their academic and professional goals. Build confidence, improve your scores, and prepare smarter with focused practice designed for real exam success. </p>
                        <a href="{{ url('/') }}" class="btn btn-dark">
                            Start Practicing Now
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