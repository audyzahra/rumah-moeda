document.addEventListener("DOMContentLoaded", function () {
    initDarkMode();
});

function initDarkMode() {
    const toggleBtn = document.getElementById("darkmode-toggle");

    if (!toggleBtn) return;

    // Load Theme
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.setAttribute("data-theme", "dark");
        toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
        document.documentElement.removeAttribute("data-theme");
        toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
    }

    // Toggle Theme
    toggleBtn.addEventListener("click", function () {

        if (document.documentElement.getAttribute("data-theme") === "dark") {

            document.documentElement.removeAttribute("data-theme");
            localStorage.setItem("theme", "light");

            toggleBtn.innerHTML =
                '<i class="fas fa-moon"></i>';

        } else {

            document.documentElement.setAttribute("data-theme", "dark");
            localStorage.setItem("theme", "dark");

            toggleBtn.innerHTML =
                '<i class="fas fa-sun"></i>';

        }

    });
}
