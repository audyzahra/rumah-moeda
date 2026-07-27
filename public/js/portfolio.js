document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.querySelector(".toolbar-search input");
    const sortSelect = document.querySelector("#sortFilter");
    const categorySelect = document.querySelector("#categoryFilter");

    const grid = document.querySelector(".portfolio-grid");

    if (!grid) return;

    const cards = [...grid.querySelectorAll(".portfolio-card")];

    /* ==========================================
        FILTER
    ========================================== */

    function filterCards() {

        const keyword = searchInput?.value.trim().toLowerCase() || "";
        const category = categorySelect?.value.trim().toLowerCase() || "";

        cards.forEach(card => {

            const title =
                card.querySelector("h3")?.textContent.toLowerCase() || "";

            const location =
                card.querySelector(".card-location")?.textContent.toLowerCase() || "";

            const cardCategory =
                card.querySelector(".card-category")
                    ?.textContent
                    .trim()
                    .toLowerCase() || "";

            const matchSearch =
                title.includes(keyword) ||
                location.includes(keyword) ||
                cardCategory.includes(keyword);

            const matchCategory =
                category === "" ||
                cardCategory === category;

            card.style.display =
                (matchSearch && matchCategory)
                    ? ""
                    : "none";

        });

    }

    /* ==========================================
        SEARCH
    ========================================== */

    searchInput?.addEventListener("keyup", filterCards);

    /* ==========================================
        CATEGORY
    ========================================== */

    categorySelect?.addEventListener("change", filterCards);

    /* ==========================================
        SORT
    ========================================== */

    sortSelect?.addEventListener("change", function () {

        const sorted = [...cards];

        sorted.sort((a, b) => {

            const dateA = a.getAttribute("data-date");
            const dateB = b.getAttribute("data-date");

            if (!dateA || !dateB) return 0;

            if (this.value === "oldest") {

                return new Date(dateA) - new Date(dateB);

            }

            return new Date(dateB) - new Date(dateA);

        });

        sorted.forEach(card => {

            grid.appendChild(card);

        });

        filterCards();

    });

});
