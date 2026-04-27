<nav class="site-header font-inter">
    <div class="examlin-container">
        <div class="header-inner">
            <a href="/" class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Examlin Logo" class="brand-image">
                <span class="brand-text font-inter">Examlin</span>
            </a>

            <div class="desktop-nav">
                <a href="/" class="nav-link">Home</a>
                
                <div class="dropdown-wrapper">
                    <button class="nav-link dropdown-trigger" aria-haspopup="true" aria-expanded="false">
                        All Courses
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    
                    <div class="dropdown-content">
                        <p class="mobile-category-title font-inter">Courses</p>
                        <div class="course-grid-inner">
                            <a href="/gmat" class="course-btn">GMAT®</a>
                            <a href="/gre" class="course-btn">GRE®</a>
                            <a href="/lsat" class="course-btn">LSAT®</a>
                            <a href="/teas" class="course-btn">TEAS®</a>
                            <a href="/hesi" class="course-btn">HESI A2®</a>
                            <a href="/nex" class="course-btn">NEX®</a>
                            <a href="/ged" class="course-btn">GED®</a>
                            <a href="/hiset" class="course-btn">HiSET®</a>
                            <a href="/accuplacer" class="course-btn">ACCUPLACER®</a>
                            <a href="/tsia2" class="course-btn">TSIA2®</a>
                        </div>
                    </div>
                </div>
         
                <a href="/about" class="nav-link">About</a>
            </div>

            <button id="mobile-menu-btn" class="mobile-toggle" aria-label="Toggle Menu">
                <svg id="icon-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
                <svg id="icon-close" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const desktopNav = document.querySelector('.desktop-nav'); // We toggle the whole nav block now
        const iconMenu = document.getElementById('icon-menu');
        const iconClose = document.getElementById('icon-close');

        btn.addEventListener('click', function() {
            desktopNav.classList.toggle('mobile-active');
            if (desktopNav.classList.contains('mobile-active')) {
                iconMenu.style.display = 'none';
                iconClose.style.display = 'block';
            } else {
                iconMenu.style.display = 'block';
                iconClose.style.display = 'none';
            }
        });
    });
</script>