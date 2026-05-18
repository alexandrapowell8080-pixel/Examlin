document.addEventListener("DOMContentLoaded", function () {

    // 1. Course Category Filters Logic
    const filterBtns = document.querySelectorAll("#course-filters .filter-btn");
    const courseGrids = document.querySelectorAll(
        ".course-grids-container .course-grid-3",
    );

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
    
    // 2. Hero Widget Graphic Animation with Hover Interaction
    function initWidgetAnimation() {
        const container = document.querySelector(".widget-graphic-container");
        const graphic = document.querySelector(".widget-graphic");
        const items = document.querySelectorAll(
            ".widget-graphic-container .widget-item",
        );

        if (!container || !graphic || items.length === 0) return;

        let currentIndex = -1;
        let animationInterval;
        let isHovering = false;

        function highlightNextItem() {
            items.forEach((item) => item.classList.remove("item-active"));

            let newIndex;
            do {
                newIndex = Math.floor(Math.random() * items.length);
            } while (newIndex === currentIndex && items.length > 1);

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
            if (animationInterval) {
                clearInterval(animationInterval);
                animationInterval = null;
            }
        }

        // Mouse enter - stop animation and highlight hovered item
        container.addEventListener("mouseenter", function () {
            isHovering = true;
            stopAnimation();
        });

        // Mouse leave - resume random animation
        container.addEventListener("mouseleave", function () {
            isHovering = false;
            // Small delay before resuming to make it feel natural
            setTimeout(() => {
                if (!isHovering) {
                    startAnimation();
                }
            }, 100);
        });

        // Mouse move over items - highlight the one being hovered
        items.forEach((item, index) => {
            item.addEventListener("mouseenter", function () {
                if (isHovering) {
                    highlightItemAtIndex(index);
                }
            });
        });

        // Start the initial animation
        setTimeout(() => {
            if (!isHovering) {
                startAnimation();
            }
        }, 200);
    }

    initWidgetAnimation();
});