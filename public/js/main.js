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
    // 2. Hero Widget Graphic Anim
    function initWidgetAnimation() {
        const container = document.querySelector(".widget-graphic-container");
        const graphic = document.querySelector(".widget-graphic");
        const items = document.querySelectorAll(
            ".widget-graphic-container .widget-item",
        );

        if (!container || !graphic || items.length === 0) return;

        let currentIndex = -1;

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

        setTimeout(highlightNextItem, 200);

        setInterval(highlightNextItem, 900);
    }

    initWidgetAnimation();
});
