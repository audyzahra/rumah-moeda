document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("portfolioFilter");

    const searchInput = document.querySelector("#searchInput");
    const sortSelect = document.querySelector("#sortFilter");
    const categorySelect = document.querySelector("#categoryFilter");

    let timer;

    /* ==========================================
        SEARCH
    ========================================== */
    searchInput?.addEventListener("keyup", function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            form.submit();
        }, 400);
    });

    /* ==========================================
        CATEGORY
    ========================================== */
    categorySelect?.addEventListener("change", function () {
        form.submit();
    });

    /* ==========================================
        SORT
    ========================================== */
    sortSelect?.addEventListener("change", function () {
        form.submit();
    });

});